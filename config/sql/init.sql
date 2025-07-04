CREATE TABLE client (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cpfcnpj VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100),
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    unit VARCHAR(10) DEFAULT 'un',
    price NUMERIC(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE invoice (
    id SERIAL PRIMARY KEY,
    client_id INTEGER REFERENCES client(id),
    number VARCHAR(20) UNIQUE NOT NULL,
    total NUMERIC(10,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE invoice_item (
    id SERIAL PRIMARY KEY,
    invoice_id INTEGER REFERENCES invoice(id),
    product_id INTEGER REFERENCES product(id),
    quantity INTEGER NOT NULL,
    unit_price NUMERIC(10,2) NOT NULL,
    total NUMERIC(10,2) GENERATED ALWAYS AS (quantity * unit_price) STORED
);
