CREATE TABLE accounts (
    accountID INT(10) NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstName VARCHAR(12) NOT NULL,
    lastName VARCHAR(12) NOT NULL,
    email VARCHAR(255) NOT NULL,
    admin CHAR(1) NOT NULL,
    PRIMARY KEY (accountID)
);

CREATE TABLE meal (
    mealID INT(10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    favorited INT(10) NOT NULL,
    accountID INT(10) NOT NULL,
    FOREIGN KEY (accountID)
    REFERENCES accounts(accountID),
    PRIMARY KEY (mealID)
);

CREATE TABLE step (
    stepID INT(10) NOT NULL AUTO_INCREMENT,
    stepNum INT(10) NOT NULL,
    description VARCHAR(255) NOT NULL,
    mealID INT(10) NOT NULL,
    FOREIGN KEY (mealID)
    REFERENCES meal(mealID),
    PRIMARY KEY (stepID)
);

CREATE TABLE components (
    componentID INT(10) NOT NULL AUTO_INCREMENT,
    ingredient VARCHAR(255) NOT NULL,
    quantity DECIMAL(12,1) NOT NULL,
    unit VARCHAR(20) NOT NULL,
    mealID INT(10) NOT NULL,
    FOREIGN KEY (mealID)
    REFERENCES meal(mealID),
    PRIMARY KEY (componentID)
);

CREATE TABLE interaction (
    interactionID INT(10) NOT NULL AUTO_INCREMENT,
    accountID INT(10) NOT NULL,
    mealID INT(10) NOT NULL,
    favorite CHAR(1) NOT NULL,
    FOREIGN KEY (accountID)
    REFERENCES accounts(accountID),
    FOREIGN KEY (mealID)
    REFERENCES meal(mealID),
    PRIMARY KEY (interactionID)
);

CREATE TABLE search (
    searchID INT(10) NOT NULL AUTO_INCREMENT,
    searchAmt INT(10) NOT NULL,
    category VARCHAR(20) NOT NULL,
    input VARCHAR(255) NOT NULL,
    PRIMARY KEY (searchID)
);
