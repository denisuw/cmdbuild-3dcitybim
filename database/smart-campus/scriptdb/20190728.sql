DROP VIEW public.view_building_room_geom;

CREATE OR REPLACE VIEW public.view_building_room_geom AS 
 SELECT b."Id",
    d."Name" AS "NamaGedung",
    c."Name" AS "NamaLantai",
    b."Name" AS "Name",
    a."Master" AS "RuangId",
    a."Geometry",
        CASE
            WHEN c."Name"::text = 'Basement'::text THEN (-1)
            WHEN c."Name"::text = 'Basement 2'::text THEN (-2)
            WHEN c."Name"::text = 'Lantai 1'::text THEN 0
            WHEN c."Name"::text = 'Lantai 2'::text THEN 1
            WHEN c."Name"::text = 'Lantai 3'::text THEN 2
            WHEN c."Name"::text = 'Lantai 4'::text THEN 3
            WHEN c."Name"::text = 'Lantai 5'::text THEN 4
            WHEN c."Name"::text = 'Lantai 6'::text THEN 5
            WHEN c."Name"::text = 'Lantai 7'::text THEN 6
            WHEN c."Name"::text = 'Lantai 8'::text THEN 7
            ELSE 0
        END AS id_lantai,
    b."PanoUrl",
    b."Code"
   FROM "Detail_Room_the_geom" a
     JOIN "Room" b ON a."Master" = b."Id"
     JOIN "Floor" c ON b."Floor" = c."Id"
     JOIN "Building" d ON c."Building" = d."Id";

ALTER TABLE public.view_building_room_geom
  OWNER TO postgres;

GO

ALTER TABLE public.basemap
ADD COLUMN has_image boolean;