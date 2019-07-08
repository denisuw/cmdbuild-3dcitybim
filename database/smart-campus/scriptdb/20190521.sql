alter table basemap add category_id integer;

-- Sequence: public.basemap_category_id_seq

-- DROP SEQUENCE public.basemap_category_id_seq;

CREATE SEQUENCE public.basemap_category_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 5
  CACHE 1;
ALTER TABLE public.basemap_category_id_seq
  OWNER TO postgres;

-- Table: public.basemap_category

-- DROP TABLE public.basemap_category;

CREATE TABLE public.basemap_category
(
  id integer NOT NULL DEFAULT nextval('basemap_category_id_seq'::regclass),
  category_name character varying(100),
  sequence integer,
  CONSTRAINT pk_basemap_category PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.basemap_category
  OWNER TO postgres;

-- View: public.view_basemap_category

-- DROP VIEW public.view_basemap_category;

CREATE OR REPLACE VIEW public.view_basemap_category AS 
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

ALTER TABLE public.view_basemap_category
  OWNER TO postgres;
