<?php

namespace Source\Models;

use DateTime;
use PDO;
use Source\Core\Model;

class User extends Model
{
    private ?int $id = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?int $document = null;
    private string|DateTime|null $createdAt = null;
    private string|DateTime|null $updatedAt = null;
    protected static array $safe = ["id", "created_at", "updated_at"];
    protected static string $entity = "users";
    protected static array $required = ["firstName", "lastName", "email", "password"];

    public function __construct()
    {
        parent::__construct("users", ["id"], ["first_name", "last_name", "email", "password"]);
    }

    public function bootstrap(string $firstName, string $lastName, string $email, ?string $password, ?int $document = null): ?User
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->document = $document;
        return $this;
    }

    public function data()
    {
        return (object)[
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "password" => $this->password,
            "document" => $this->document ?? null,
            "createdAt" => $this->createdAt ?? null,
            "updatedAt" => $this->updatedAt ?? null
        ];
    }

    public function findById(int $id, string $columns = '*'): ?User
    {
        $find = $this->find(
            'id = :id',
            "id={$id}",
            $columns
        );

        return $find->fetch();
    }

    public function findByEmail(string $email, string $columns = '*'): ?User
    {
        $find = $this->find(
            'email = :email',
            "email={$email}",
            $columns
        );

        return $find->fetch();
    }

    public function save(): bool
    {
        if (!$this->required()) {
            return false;
        }

        if(!is_email($this->email)){
            $this->message->warning("O e-mail informado não é válido!");
            return false;
        }

        /**
         * User Create
         */
        if (empty($this->id)) {

            if (empty($this->password)) {
                $this->message->warning("A senha é obrigatória.");
                return false;
            }

            if (!is_password($this->password)) {
                $min = CONFIG_PASSWORD_MIN_LENGHT;
                $max = CONFIG_PASSWORD_MAX_LENGHT;

                $this->message->warning(
                    "A senha deve ter entre {$min} e {$max} caracteres!"
                );
                return false;
            }

            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado!");
                return false;
            }

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);

            $this->data = (object)[
                "first_name" => $this->firstName,
                "last_name"  => $this->lastName,
                "email"      => $this->email,
                "password"   => $this->password,
                "document"   => $this->document ?? null
            ];

            $userId = $this->create((array)$this->data);

            if (!$userId) {
                $this->message->error("Erro ao cadastrar, verifique os dados!");
                return false;
            }

            $this->message->success("Cadastro realizado com sucesso!");
        }

        /**
         * User Update
         */
        if (!empty($this->id)) {
            $userId = $this->id;

            $email = $this->read(
                "SELECT id FROM " . self::$entity . " WHERE email = :email AND id != :id",
                "email={$this->email}&id={$userId}"
            );

            if ($email && $email->rowCount()) {
                $this->message->warning("O e-mail informado já está cadastrado!");
                return false;
            }

            $this->data = (object)[
                "first_name" => $this->firstName,
                "last_name"  => $this->lastName,
                "email"      => $this->email,
                "document"   => $this->document ?? null
            ];

            if (!empty($this->password)) {
                if (!is_password($this->password)) {
                    $this->message->warning("Senha inválida.");
                    return false;
                }

                $this->data->password = password_hash($this->password, PASSWORD_DEFAULT);
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");

            if (!$userId) {
                $this->message->error("Erro ao atualizar, verifique os dados!");
                return false;
            }

            $this->message->success("Cadastro atualizado com sucesso!");
        }

        $this->data = $this->read(
            "SELECT * FROM " . self::$entity . " WHERE id = :id LIMIT 1",
            "id={$userId}"
        )->fetch(PDO::FETCH_OBJ);

        return true;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getDocument(): ?int
    {
        return $this->document;
    }

    public function setDocument(?int $document): void
    {
        $this->document = $document;
    }

    public function getCreatedAt(): string|DateTime|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string|DateTime|null $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string|DateTime|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string|DateTime|null $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}