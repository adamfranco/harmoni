--
-- Name: test; Type: TABLE; Schema: public; Owner: afranco; Tablespace: 
--

DROP TABLE IF EXISTS test;

CREATE TABLE test (
    id integer NOT NULL,
    "fk" integer,
    value character varying(255) NOT NULL
);

--
-- Name: test_id_seq; Type: SEQUENCE; Schema: public; Owner: afranco
--
DROP SEQUENCE IF EXISTS test_id_seq;

CREATE SEQUENCE test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');
INSERT INTO test VALUES (NEXTVAL('test_id_seq'), 0, 'This is the value');

--
-- Name: test; Type: TABLE; Schema: public; Owner: afranco; Tablespace: 
--

DROP TABLE IF EXISTS test1;

CREATE TABLE test1 (
    id integer NOT NULL,
    value character varying(255) NOT NULL
);

--
-- Name: test_id_seq; Type: SEQUENCE; Schema: public; Owner: afranco
--
DROP SEQUENCE IF EXISTS test1_id_seq;

CREATE SEQUENCE test1_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;