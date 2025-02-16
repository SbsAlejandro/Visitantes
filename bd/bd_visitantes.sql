PGDMP  /                    |            bd_visitante    14.13    16.4 7    +           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            ,           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            -           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            .           1262    132703    bd_visitante    DATABASE        CREATE DATABASE bd_visitante WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE bd_visitante;
                postgres    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                postgres    false            /           0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    4            �            1259    132705    departamentos    TABLE     �   CREATE TABLE public.departamentos (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    estatus smallint NOT NULL,
    fecha character varying(255) NOT NULL
);
 !   DROP TABLE public.departamentos;
       public         heap    postgres    false    4            �            1259    132704    departamentos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.departamentos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.departamentos_id_seq;
       public          postgres    false    4    210            0           0    0    departamentos_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.departamentos_id_seq OWNED BY public.departamentos.id;
          public          postgres    false    209            �            1259    132724    personas    TABLE     �   CREATE TABLE public.personas (
    id integer NOT NULL,
    cedula character varying(255) NOT NULL,
    nombre character varying(200) NOT NULL,
    apellido character varying(200) NOT NULL
);
    DROP TABLE public.personas;
       public         heap    postgres    false    4            �            1259    132723    personas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.personas_id_seq;
       public          postgres    false    4    212            1           0    0    personas_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.personas_id_seq OWNED BY public.personas.id;
          public          postgres    false    211            �            1259    132743 
   personasno    TABLE     
  CREATE TABLE public.personasno (
    id integer NOT NULL,
    cedula integer NOT NULL,
    nombre character varying(255) NOT NULL,
    apellido character varying(55) NOT NULL,
    estatus character varying(255) NOT NULL,
    fecha character varying(255) NOT NULL
);
    DROP TABLE public.personasno;
       public         heap    postgres    false    4            �            1259    132742    personasno_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personasno_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.personasno_id_seq;
       public          postgres    false    4    214            2           0    0    personasno_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.personasno_id_seq OWNED BY public.personasno.id;
          public          postgres    false    213            �            1259    132762    roles    TABLE     �   CREATE TABLE public.roles (
    id integer NOT NULL,
    rol character varying(255) NOT NULL,
    estatus integer NOT NULL,
    fecha character varying(255) NOT NULL
);
    DROP TABLE public.roles;
       public         heap    postgres    false    4            �            1259    132761    roles_id_seq    SEQUENCE     �   CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    216    4            3           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    215            �            1259    132781    usuario    TABLE     �  CREATE TABLE public.usuario (
    id integer NOT NULL,
    cedula integer NOT NULL,
    usuario character varying(50) NOT NULL,
    nombre character varying(50) NOT NULL,
    apellido character varying(50) NOT NULL,
    correo character varying(50) NOT NULL,
    foto character varying(255) NOT NULL,
    fecha character varying(255) NOT NULL,
    contrasena character varying(255) NOT NULL,
    rol integer NOT NULL,
    estatus integer NOT NULL
);
    DROP TABLE public.usuario;
       public         heap    postgres    false    4            �            1259    132780    usuario_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.usuario_id_seq;
       public          postgres    false    4    218            4           0    0    usuario_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;
          public          postgres    false    217            �            1259    132800    ves_per    TABLE     �  CREATE TABLE public.ves_per (
    id integer NOT NULL,
    id_visitantes integer NOT NULL,
    id_personas integer NOT NULL,
    empresa character varying(255) NOT NULL,
    telefono character varying(255) NOT NULL,
    codigo_carnet character varying(255) NOT NULL,
    foto character varying(255) NOT NULL,
    fecha date DEFAULT CURRENT_DATE NOT NULL,
    hora character varying(255) NOT NULL,
    meridiano character varying(255) NOT NULL
);
    DROP TABLE public.ves_per;
       public         heap    postgres    false    4            �            1259    132799    ves_per_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ves_per_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.ves_per_id_seq;
       public          postgres    false    4    220            5           0    0    ves_per_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.ves_per_id_seq OWNED BY public.ves_per.id;
          public          postgres    false    219            �            1259    132820    visitas    TABLE     �   CREATE TABLE public.visitas (
    id integer NOT NULL,
    autorizador character varying(255) NOT NULL,
    departamento integer NOT NULL,
    piso integer NOT NULL,
    estatus smallint NOT NULL,
    asunto character varying(255) NOT NULL
);
    DROP TABLE public.visitas;
       public         heap    postgres    false    4            �            1259    132819    visitas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.visitas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.visitas_id_seq;
       public          postgres    false    222    4            6           0    0    visitas_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.visitas_id_seq OWNED BY public.visitas.id;
          public          postgres    false    221            z           2604    132708    departamentos id    DEFAULT     t   ALTER TABLE ONLY public.departamentos ALTER COLUMN id SET DEFAULT nextval('public.departamentos_id_seq'::regclass);
 ?   ALTER TABLE public.departamentos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    210    209    210            {           2604    132727    personas id    DEFAULT     j   ALTER TABLE ONLY public.personas ALTER COLUMN id SET DEFAULT nextval('public.personas_id_seq'::regclass);
 :   ALTER TABLE public.personas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    211    212    212            |           2604    132746    personasno id    DEFAULT     n   ALTER TABLE ONLY public.personasno ALTER COLUMN id SET DEFAULT nextval('public.personasno_id_seq'::regclass);
 <   ALTER TABLE public.personasno ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    213    214    214            }           2604    132765    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    216    216            ~           2604    132784 
   usuario id    DEFAULT     h   ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);
 9   ALTER TABLE public.usuario ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    218    217    218                       2604    132803 
   ves_per id    DEFAULT     h   ALTER TABLE ONLY public.ves_per ALTER COLUMN id SET DEFAULT nextval('public.ves_per_id_seq'::regclass);
 9   ALTER TABLE public.ves_per ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    220    220            �           2604    132823 
   visitas id    DEFAULT     h   ALTER TABLE ONLY public.visitas ALTER COLUMN id SET DEFAULT nextval('public.visitas_id_seq'::regclass);
 9   ALTER TABLE public.visitas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221    222                      0    132705    departamentos 
   TABLE DATA           C   COPY public.departamentos (id, nombre, estatus, fecha) FROM stdin;
    public          postgres    false    210   =                 0    132724    personas 
   TABLE DATA           @   COPY public.personas (id, cedula, nombre, apellido) FROM stdin;
    public          postgres    false    212   ;=                  0    132743 
   personasno 
   TABLE DATA           R   COPY public.personasno (id, cedula, nombre, apellido, estatus, fecha) FROM stdin;
    public          postgres    false    214   X=       "          0    132762    roles 
   TABLE DATA           8   COPY public.roles (id, rol, estatus, fecha) FROM stdin;
    public          postgres    false    216   u=       $          0    132781    usuario 
   TABLE DATA           w   COPY public.usuario (id, cedula, usuario, nombre, apellido, correo, foto, fecha, contrasena, rol, estatus) FROM stdin;
    public          postgres    false    218   �=       &          0    132800    ves_per 
   TABLE DATA           �   COPY public.ves_per (id, id_visitantes, id_personas, empresa, telefono, codigo_carnet, foto, fecha, hora, meridiano) FROM stdin;
    public          postgres    false    220   B>       (          0    132820    visitas 
   TABLE DATA           W   COPY public.visitas (id, autorizador, departamento, piso, estatus, asunto) FROM stdin;
    public          postgres    false    222   _>       7           0    0    departamentos_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.departamentos_id_seq', 1, false);
          public          postgres    false    209            8           0    0    personas_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.personas_id_seq', 1, false);
          public          postgres    false    211            9           0    0    personasno_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.personasno_id_seq', 1, false);
          public          postgres    false    213            :           0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 3, true);
          public          postgres    false    215            ;           0    0    usuario_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.usuario_id_seq', 1, true);
          public          postgres    false    217            <           0    0    ves_per_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.ves_per_id_seq', 1, false);
          public          postgres    false    219            =           0    0    visitas_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.visitas_id_seq', 1, false);
          public          postgres    false    221            �           2606    132722    departamentos pk_departamentos 
   CONSTRAINT     \   ALTER TABLE ONLY public.departamentos
    ADD CONSTRAINT pk_departamentos PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.departamentos DROP CONSTRAINT pk_departamentos;
       public            postgres    false    210            �           2606    132741    personas pk_personas 
   CONSTRAINT     R   ALTER TABLE ONLY public.personas
    ADD CONSTRAINT pk_personas PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.personas DROP CONSTRAINT pk_personas;
       public            postgres    false    212            �           2606    132760    personasno pk_personasno 
   CONSTRAINT     V   ALTER TABLE ONLY public.personasno
    ADD CONSTRAINT pk_personasno PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.personasno DROP CONSTRAINT pk_personasno;
       public            postgres    false    214            �           2606    132779    roles pk_roles 
   CONSTRAINT     L   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT pk_roles PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.roles DROP CONSTRAINT pk_roles;
       public            postgres    false    216            �           2606    132798    usuario pk_usuario 
   CONSTRAINT     P   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.usuario DROP CONSTRAINT pk_usuario;
       public            postgres    false    218            �           2606    132818    ves_per pk_ves_per 
   CONSTRAINT     P   ALTER TABLE ONLY public.ves_per
    ADD CONSTRAINT pk_ves_per PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.ves_per DROP CONSTRAINT pk_ves_per;
       public            postgres    false    220            �           2606    132837    visitas pk_visitas 
   CONSTRAINT     P   ALTER TABLE ONLY public.visitas
    ADD CONSTRAINT pk_visitas PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.visitas DROP CONSTRAINT pk_visitas;
       public            postgres    false    222                  x������ � �            x������ � �             x������ � �      "   D   x�3�qu����w�t�4�4202�54�50�2�tt����	rt�B�4�u��W@����� ���      $   i   x��A@0 ��������g$+���R2�����! �m9����U�����������T-��`S���pm;X�g�w��:H!�E"`�����f�{�-�      &      x������ � �      (      x������ � �     