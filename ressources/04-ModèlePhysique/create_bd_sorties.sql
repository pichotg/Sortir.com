-- Script de création de la base de données SORTIES
--   type :      SQL Server 2012
--


CREATE TABLE ETATS (
    no_etat   INTEGER NOT NULL,
    libelle   VARCHAR(30) NOT NULL
)

ALTER TABLE ETATS ADD constraint etats_pk PRIMARY KEY (no_etat)


CREATE TABLE INSCRIPTIONS (
    date_inscription              smalldatetime NOT NULL,
    sorties_no_sortie             INTEGER NOT NULL,
    participants_no_participant   INTEGER NOT NULL
)

ALTER TABLE INSCRIPTIONS ADD constraint inscriptions_pk PRIMARY KEY  (SORTIES_no_sortie, PARTICIPANTS_no_participant)


CREATE TABLE LIEUX (
    no_lieu         INTEGER NOT NULL,
    nom_lieu        VARCHAR(30) NOT NULL,
    rue             VARCHAR(30),
    latitude           FLOAT,
    longitude          FLOAT,
    villes_no_ville   INTEGER NOT NULL,
)

ALTER TABLE LIEUX ADD constraint lieux_pk PRIMARY KEY  (no_lieu)


CREATE TABLE PARTICIPANTS (
    no_participant   INTEGER NOT NULL,
	pseudo           VARCHAR(30) NOT NULL,
    nom              VARCHAR(30) NOT NULL,
    prenom           VARCHAR(30) NOT NULL,
    telephone        VARCHAR(15),
    mail             VARCHAR(20) NOT NULL,
	mot_de_passe	 VARCHAR(20) NOT NULL,
    administrateur   bit NOT NULL,
    actif            bit NOT NULL,
	campus_no_campus    INTEGER NOT NULL
)

ALTER TABLE PARTICIPANTS ADD constraint participants_pk PRIMARY KEY  (no_participant)

ALTER TABLE PARTICIPANTS add constraint participants_pseudo_uk unique (pseudo)

CREATE TABLE CAMPUS (
    no_campus       INTEGER NOT NULL,
    nom_campus      VARCHAR(30) NOT NULL
)

ALTER TABLE CAMPUS ADD constraint campus_pk PRIMARY KEY (no_campus)

CREATE TABLE SORTIES (
    no_sortie                     INTEGER NOT NULL,
    nom                           VARCHAR(30) NOT NULL,
    datedebut                     smalldatetime NOT NULL,
    duree                         INTEGER,
    datecloture                   smalldatetime NOT NULL,
    nbinscriptionsmax             INTEGER NOT NULL,
    descriptioninfos              VARCHAR(500),
    etatsortie                    INTEGER,
	urlPhoto                      VARCHAR(250),
    organisateur                  INTEGER NOT NULL,
    lieux_no_lieu                 INTEGER NOT NULL,
    etats_no_etat                 INTEGER NOT NULL
)

ALTER TABLE SORTIES ADD constraint sorties_pk PRIMARY KEY  (no_sortie)

CREATE TABLE VILLES (
    no_ville      INTEGER NOT NULL,
    nom_ville     VARCHAR(30) NOT NULL,
    code_postal   VARCHAR(10) NOT NULL
)

ALTER TABLE VILLES ADD constraint villes_pk PRIMARY KEY  (no_ville)

ALTER TABLE INSCRIPTIONS
    ADD CONSTRAINT inscriptions_participants_fk FOREIGN KEY ( participants_no_participant )
        REFERENCES participants ( no_participant )
ON DELETE NO ACTION 
    ON UPDATE no action 

ALTER TABLE INSCRIPTIONS
    ADD CONSTRAINT inscriptions_sorties_fk FOREIGN KEY ( sorties_no_sortie )
        REFERENCES sorties ( no_sortie )
ON DELETE NO ACTION 
    ON UPDATE no action 


ALTER TABLE LIEUX
    ADD CONSTRAINT lieux_villes_fk FOREIGN KEY ( villes_no_ville )
        REFERENCES villes ( no_ville )
ON DELETE NO ACTION 
    ON UPDATE no action 
	
ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_etats_fk FOREIGN KEY ( etats_no_etat )
        REFERENCES etats ( no_etat )
ON DELETE NO ACTION 
    ON UPDATE no action 

ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_lieux_fk FOREIGN KEY ( lieux_no_lieu )
        REFERENCES lieux ( no_lieu )
ON DELETE NO ACTION 
    ON UPDATE no action 

ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_participants_fk FOREIGN KEY ( organisateur )
        REFERENCES participants ( no_participant )
ON DELETE NO ACTION 
    ON UPDATE no action 


