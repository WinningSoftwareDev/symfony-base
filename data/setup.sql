DROP SCHEMA IF EXISTS Authentication;
DROP SCHEMA IF EXISTS Core;

CREATE SCHEMA Authentication;
CREATE SCHEMA Core;

CREATE TABLE Authentication.tblUser (
    intUserId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    strEmail VARCHAR(180) NOT NULL,
    strPassword VARCHAR(255) DEFAULT NULL COMMENT 'Hashed password (null for OAuth-only users)',
    bolVerified TINYINT(1) NOT NULL DEFAULT 0,
    bolActive TINYINT(1) NOT NULL DEFAULT 1,
    strOauthProvider VARCHAR(32) DEFAULT NULL COMMENT 'OAuth provider name (github, google)',
    strOauthId VARCHAR(255) DEFAULT NULL COMMENT 'OAuth provider user ID',
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intUserId),
    UNIQUE KEY UK_tblUser_strEmail (strEmail),
    UNIQUE KEY UK_tblUser_strOauth (strOauthProvider, strOauthId),
    INDEX I_tblUser_bolActive (bolActive),
    INDEX I_tblUser_bolVerified (bolVerified),
    INDEX I_tblUser_dtmCreated (dtmCreated)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblRole (
    intRoleId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    strRoleName VARCHAR(50) NOT NULL,
    strHandle VARCHAR(50) NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intRoleId),
    UNIQUE KEY UK_tblRole_strHandle (strHandle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblPermission (
    intPermissionId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    strPermissionName VARCHAR(50) NOT NULL,
    strHandle VARCHAR(50) NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intPermissionId),
    UNIQUE KEY UK_tblPermission_strHandle (strHandle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblRolePermission (
    intRoleId INT UNSIGNED NOT NULL,
    intPermissionId INT UNSIGNED NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intRoleId, intPermissionId),
    FOREIGN KEY FK_tblRolePermission_intRoleId (intRoleId)
        REFERENCES Authentication.tblRole(intRoleId),
    FOREIGN KEY FK_tblRolePermission_intPermissionId (intPermissionId)
        REFERENCES Authentication.tblPermission(intPermissionId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblUserRole (
    intUserId INT UNSIGNED NOT NULL,
    intRoleId INT UNSIGNED NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intUserId, intRoleId),
    FOREIGN KEY FK_tblUserRole_intUserId (intUserId) REFERENCES Authentication.tblUser(intUserId),
    FOREIGN KEY FK_tblUserRole_intRoleId (intRoleId) REFERENCES Authentication.tblRole(intRoleId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblEmailVerificationToken (
    intEmailVerificationTokenId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    intUserId INT UNSIGNED NOT NULL,
    strToken VARCHAR(100) NOT NULL,
    dtmExpires DATETIME NOT NULL,
    dtmVerified DATETIME,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intEmailVerificationTokenId),
    FOREIGN KEY FK_tblVerificationToken_intUserId (intUserId)
        REFERENCES Authentication.tblUser(intUserId),
    UNIQUE KEY UK_tblVerificationToken_strToken (strToken),
    INDEX I_tblVerificationToken_intUserId (intUserId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Authentication.tblPasswordResetToken (
    intPasswordResetTokenId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    intUserId INT UNSIGNED NOT NULL,
    strToken VARCHAR(100) NOT NULL,
    dtmExpires DATETIME NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    dtmUpdated DATETIME ON UPDATE NOW(),
    PRIMARY KEY (intPasswordResetTokenId),
    FOREIGN KEY FK_tblPasswordResetToken_intUserId (intUserId)
        REFERENCES Authentication.tblUser(intUserId),
    UNIQUE KEY UK_tblPasswordResetToken_strToken (strToken),
    INDEX I_tblPasswordResetToken_intUserId (intUserId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE Core.ublEmailType (
    intEmailTypeId INT UNSIGNED NOT NULL AUTO_INCREMENT,
    strEmailTypeSubject VARCHAR(255) NOT NULL,
    strEmailTypeHandle VARCHAR(100) NOT NULL,
    strTemplate VARCHAR(255) NOT NULL,
    PRIMARY KEY (intEmailTypeId),
    UNIQUE KEY UK_ublEmailType_strEmailType (strEmailTypeHandle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO Core.ublEmailType
    (strEmailTypeSubject, strEmailTypeHandle, strTemplate)
VALUES
    ('Verify your email address', 'VERIFY_EMAIL_ADDRESS', 'Core/Email/verify-email.latte'),
    ('Reset your password', 'PASSWORD_RESET', 'Core/Email/reset-password.latte');

INSERT INTO Authentication.tblRole
    (strRoleName, strHandle)
VALUES
    ('User', 'ROLE_USER'),
    ('Administrator', 'ROLE_ADMIN');
