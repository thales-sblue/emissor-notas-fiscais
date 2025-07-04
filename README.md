# 📄 Emissor de Nota Fiscal

Sistema simples emissão de notas fiscais com cadastro de clientes, produtos, geração de notas com múltiplos itens e exportação em PDF.

Desenvolvido em PHP puro com arquitetura MVC, integração com Vue.js no frontend e PostgreSQL como banco de dados.

---

## 🚀 Funcionalidades

- ✅ Cadastro de clientes com CPF/CNPJ
- ✅ Cadastro de produtos com unidade e preço
- ✅ Emissão de notas fiscais com múltiplos produtos
- ✅ Cálculo automático do total da nota
- ✅ Geração de número sequencial da nota fiscal
- ✅ Exportação em PDF da nota emitida
- ✅ Interface moderna com Vue.js
- ✅ Banco de dados versionado com Docker + PostgreSQL

---

## 🧱 Tecnologias utilizadas

- **Backend:** PHP 8+ (puro, com namespaces e PSR-4)
- **Frontend:** Vue.js 3 (via CDN)
- **Banco de Dados:** PostgreSQL
- **Ambiente:** Docker e Docker Compose
- **PDF:** Dompdf

---

## ⚙️ Como rodar o projeto

### Pré-requisitos:

- PHP 8.1+
- Composer
- Docker + Docker Compose

### Passo a passo:

1. Clone o repositório:

   ```bash
   git clone https://github.com/seu-usuario/emissor-nf.git
   cd emissor-nf
   ```

2. Suba o banco de dados e o app com Docker:

   ```bash
   docker-compose up --build
   ```

3. Acesse:
   [http://localhost:8000](http://localhost:8000)

---
