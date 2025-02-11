CREATE TABLE migration (
    id BIGSERIAL NOT NULL PRIMARY KEY,
    database VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL UNIQUE,
    status SMALLINT NOT NULL DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    executed_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX migration_status ON migration (status);