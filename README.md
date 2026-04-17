# **Trainee 2026.1**

# **Nome do seu blog**

## **Projeto Trainee, Code Jr, 2026.1**

| **Sumário** |
|-------------|
| [Equipe](#Equipe) |
| [Descrição do Projeto](#Descrição-do-Projeto) |
| [Preparação do Ambiente (Instalações)](#Preparação-do-Ambiente) |
| [Tutorial Git](#Tutorial-Git) |
| [Executando o Projeto](#Executando-o-Projeto) |

---

## Equipe

#### Desenvolvedores:
* [Trainee 1](coloque o link do github)
* [Trainee 2](coloque o link do github)
* [Trainee 3](coloque o link do github)
* [Trainee 4](coloque o link do github)

#### Scrum Master:
* [Nome do Scrum](coloque o link do github).

#### Links Úteis:
* [Trello do Projeto]()

---

## Descrição do Projeto

* Blog / Sistema de treinamento e capacitação dos Trainees da [CodeJR](https://codejr.com.br/), na gestão 2026.1;
* Possuirá Front-End em HTML, CSS, JavaScript, Bootstrap e Back-End em PHP (puro), com Banco de Dados MySQL;

---

## Preparação do Ambiente

Para rodar este projeto, você precisará de algumas ferramentas. Você pode instalá-las rapidamente via terminal utilizando o **Winget** (Gerenciador de pacotes nativo do Windows) ou pelos links de download tradicionais.

> **Não tem o Winget instalado?**
> Verifique abrindo o terminal e digitando `winget -v`. Se der erro, abra o **PowerShell** como administrador e rode:
> ```powershell
> Invoke-WebRequest -Uri [https://aka.ms/getwinget](https://aka.ms/getwinget) -OutFile winget.msixbundle
> Add-AppxPackage winget.msixbundle
> ```

### 1. Git
Ferramenta de versionamento de código.
* **Via Winget:** `winget install --id Git.Git -e --source winget`
* **Download Manual:** [Página de Downloads do Git](https://git-scm.com/downloads)

### 2. Node.js
Ambiente de execução JavaScript (necessário para alguns pacotes e ferramentas de front-end).
* **Via Winget:** `winget install OpenJS.NodeJS`
* **Download Manual:** [Site Oficial do Node.js](https://nodejs.org/)

### 3. Docker Desktop
Para rodar contêineres e facilitar a configuração do banco de dados e ambiente.
* **Via Winget:** `winget install -e --id Docker.DockerDesktop`
* **Download Manual:** [Site Oficial do Docker](https://www.docker.com/products/docker-desktop/)

### 4. PHP (8.0+)
A linguagem base do nosso Back-End.
* **Via Winget:** `winget install php`
* **Download Manual:** [Downloads PHP para Windows](https://windows.php.net/download/)

### 5. Composer
Gerenciador de dependências do PHP.
* **Via Winget:** `winget install Composer.Composer`
* **Download Manual:** [Site Oficial do Composer](https://getcomposer.org/download/)

---

## Tutorial Git

### Primeira Configuração
Após instalar o Git, abra o terminal e configure suas credenciais <sub>(Substitua o nome e o e-mail para o seu)</sub>:
```bash
git config --global user.name "nomeDeUsuario"
git config --global user.email email@codejr.com.br
```
## Tutorial Git

### Primeira Configuração
Após instalar o DockerDesktop, abra o terminal e execute o seguinte comando para baixar todas as dependências necessárias:
```bash
docker-compose up -d --build
```
### Após a primeira configuração
Não é necessário executar o build após a primeira vez, sendo assim execute apenas o comando a seguir:
```bash
docker-compose up -d
```
