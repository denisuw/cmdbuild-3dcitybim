CREATE SEQUENCE gis.basemap_id_seq
    INCREMENT 1
    START 5
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE gis.basemap_id_seq
    OWNER TO postgres;
	
-- Table: gis.basemap

-- DROP TABLE gis.basemap;

CREATE TABLE gis.basemap
(
    id integer NOT NULL DEFAULT nextval('basemap_id_seq'::regclass),
    name character varying(255) COLLATE pg_catalog."default",
    title character varying(255) COLLATE pg_catalog."default",
    visible boolean,
    max_resolution character varying(255) COLLATE pg_catalog."default",
    min_resolution character varying(255) COLLATE pg_catalog."default",
    base_layer character varying(255) COLLATE pg_catalog."default",
    url text COLLATE pg_catalog."default",
    params text COLLATE pg_catalog."default",
    opacity double precision,
    active boolean,
    sequence integer,
    "cqlFilter" text COLLATE pg_catalog."default",
    CONSTRAINT basemap_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE gis.basemap
    OWNER to postgres;
	
	
	
	
alter table basemap add category_id integer;

-- Sequence: gis.basemap_category_id_seq

-- DROP SEQUENCE gis.basemap_category_id_seq;

CREATE SEQUENCE gis.basemap_category_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 5
  CACHE 1;
ALTER TABLE gis.basemap_category_id_seq
  OWNER TO postgres;

-- Table: gis.basemap_category

-- DROP TABLE gis.basemap_category;

CREATE TABLE gis.basemap_category
(
  id integer NOT NULL DEFAULT nextval('basemap_category_id_seq'::regclass),
  category_name character varying(100),
  sequence integer,
  CONSTRAINT pk_basemap_category PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE gis.basemap_category
  OWNER TO postgres;

-- View: gis.view_basemap_category

-- DROP VIEW gis.view_basemap_category;

CREATE OR REPLACE VIEW gis.view_basemap_category AS 
 SELECT a.id,
    a.name,
    a.title,
    a.visible,
    a.max_resolution,
    a.min_resolution,
    a.base_layer,
    a.url,
    a.params,
    a.opacity,
    a.active,
    a.sequence,
    a."cqlFilter",
    a.category_id,
    b.category_name,
    b.sequence AS category_seq
   FROM basemap a
     LEFT JOIN basemap_category b ON a.category_id = b.id
  WHERE a.category_id IS NOT NULL;

ALTER TABLE gis.view_basemap_category
  OWNER TO postgres;
