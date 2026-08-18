-- SQL Schema & Initial Data for Supabase PostgreSQL (Cippy Dimsum POS)

-- 1. Table Menu
CREATE TABLE IF NOT EXISTS menu (
    id SERIAL PRIMARY KEY,
    variant VARCHAR(50) NOT NULL,
    category VARCHAR(100) NOT NULL,
    name VARCHAR(255) NOT NULL,
    portion VARCHAR(100) DEFAULT '',
    price INT NOT NULL,
    cost INT NOT NULL DEFAULT 0,
    is_available INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table Transactions
CREATE TABLE IF NOT EXISTS transactions (
    id SERIAL PRIMARY KEY,
    transaction_code VARCHAR(100) UNIQUE NOT NULL,
    total_amount INT NOT NULL,
    total_cost INT NOT NULL DEFAULT 0,
    profit INT NOT NULL DEFAULT 0,
    payment_method VARCHAR(50) NOT NULL,
    cash_given INT DEFAULT 0,
    change_amount INT DEFAULT 0,
    customer_note TEXT DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table Transaction Items
CREATE TABLE IF NOT EXISTS transaction_items (
    id SERIAL PRIMARY KEY,
    transaction_id INT NOT NULL,
    menu_id INT,
    menu_name VARCHAR(255) NOT NULL,
    variant VARCHAR(50) NOT NULL,
    portion VARCHAR(100) DEFAULT '',
    price INT NOT NULL,
    cost INT NOT NULL DEFAULT 0,
    quantity INT NOT NULL,
    subtotal INT NOT NULL,
    subtotal_cost INT NOT NULL DEFAULT 0,
    item_note TEXT DEFAULT ''
);

-- 4. Seed Default Cippy Dimsum Menus (26 Items)
INSERT INTO menu (variant, category, name, portion, price, cost) VALUES
('mini', 'Mentai / Mayo Cheese', 'Small Box Mentai/Mayo Cheese', 'isi 4 pcs', 10000, 6000),
('mini', 'Mentai / Mayo Cheese', 'Medium Box Mentai/Mayo Cheese', 'isi 6 pcs', 15000, 9000),
('mini', 'Mentai / Mayo Cheese', 'Large Box Mentai/Mayo Cheese', 'isi 10 pcs', 24000, 14000),
('mini', 'Mentai / Mayo Cheese', 'Extra Large Box Mentai/Mayo Cheese', 'isi 16 pcs', 37000, 22000),
('mini', 'Dimsum Lava', 'Small Box Dimsum Lava', 'isi 4 pcs', 9000, 5500),
('mini', 'Dimsum Lava', 'Medium Box Dimsum Lava', 'isi 6 pcs', 14000, 8500),
('mini', 'Dimsum Lava', 'Large Box Dimsum Lava', 'isi 10 pcs', 22000, 13000),
('mini', 'Dimsum Lava', 'Extra Large Box Dimsum Lava', 'isi 16 pcs', 36000, 21000),
('mini', 'Dimsum Original', 'Dimsum Ori Mini', 'per pcs (free saus)', 2000, 1100),
('mini', 'Dimsum Bakar', 'Dimsum Bakar Ori Mini', 'isi 3 pcs', 8000, 4800),
('mini', 'Dimsum Bakar', 'Dimsum Bakar Topping Mini', 'isi 3 pcs (Mentai, Nori, Boncabe)', 10000, 6000),
('mini', 'Party Box Mix', 'Large Party Box Mix Mini', '10 pcs (4 Mentai, 4 Mayo, 2 Lava)', 26000, 15000),
('mini', 'Party Box Mix', 'XL Party Box Mix Mini', '16 pcs (4 Mentai, 4 Mayo, 4 Hot, 4 Lava)', 44000, 25000),
('besar', 'Mentai / Mayo Cheese', 'Small Box Mentai/Mayo Cheese', 'isi 4 pcs', 18000, 11000),
('besar', 'Mentai / Mayo Cheese', 'Medium Box Mentai/Mayo Cheese', 'isi 6 pcs', 26000, 16000),
('besar', 'Mentai / Mayo Cheese', 'Large Box Mentai/Mayo Cheese', 'isi 10 pcs', 45000, 27000),
('besar', 'Mentai / Mayo Cheese', 'Extra Large Box Mentai/Mayo Cheese', 'isi 16 pcs', 68000, 40000),
('besar', 'Dimsum Lava', 'Small Box Dimsum Lava', 'isi 4 pcs', 17000, 10500),
('besar', 'Dimsum Lava', 'Medium Box Dimsum Lava', 'isi 6 pcs', 25000, 15000),
('besar', 'Dimsum Lava', 'Large Box Dimsum Lava', 'isi 10 pcs', 44000, 26000),
('besar', 'Dimsum Lava', 'Extra Large Box Dimsum Lava', 'isi 16 pcs', 65000, 39000),
('besar', 'Dimsum Original', 'Dimsum Ori Besar', 'per pcs (free saus)', 4000, 2200),
('besar', 'Dimsum Bakar', 'Dimsum Bakar Ori Besar', 'isi 3 pcs', 12000, 7200),
('besar', 'Dimsum Bakar', 'Dimsum Bakar Topping Besar', 'isi 3 pcs (Mentai, Nori, Boncabe)', 14000, 8500),
('besar', 'Party Box Mix', 'Large Party Box Mix Besar', '10 pcs (4 Mentai, 4 Mayo, 2 Lava)', 50000, 30000),
('besar', 'Party Box Mix', 'XL Party Box Mix Besar', '16 pcs (4 Mentai, 4 Mayo, 4 Hot, 4 Lava)', 75000, 45000);
