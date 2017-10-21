--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: update_left_right(integer); Type: FUNCTION; Schema: public; Owner: bioerp
--

CREATE FUNCTION update_left_right(pic integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
    declare update_node int;
    declare current_root_id int;
    BEGIN
    select
        rgt, root_id
        into update_node, current_root_id
    from users where id =
        (select pid from users where id = pic)
    ;
    update users set lft = case when lft >= update_node then lft + 2
                                      else lft end,
                         rgt = rgt + 2
        where rgt >= update_node - 1;
    END;
    $$;


ALTER FUNCTION public.update_left_right(pic integer) OWNER TO bioerp;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: address_books; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE address_books (
    id integer NOT NULL,
    user_id integer,
    contact character varying(10),
    province_id integer,
    city_id integer,
    address_info character varying,
    remark character varying,
    create_time timestamp without time zone DEFAULT now(),
    mobile character varying(20)
);


ALTER TABLE address_books OWNER TO bioerp;

--
-- Name: address_books_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE address_books_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE address_books_id_seq OWNER TO bioerp;

--
-- Name: address_books_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE address_books_id_seq OWNED BY address_books.id;


--
-- Name: admins; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE admins (
    id integer NOT NULL,
    username character(20) NOT NULL,
    password character(32) NOT NULL,
    login_time timestamp without time zone
);


ALTER TABLE admins OWNER TO bioerp;

--
-- Name: admins_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE admins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE admins_id_seq OWNER TO bioerp;

--
-- Name: admins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE admins_id_seq OWNED BY admins.id;


--
-- Name: alipay_logs; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE alipay_logs (
    id integer NOT NULL,
    log_time timestamp without time zone DEFAULT now(),
    log text,
    is_sign character varying,
    response_text character varying
);


ALTER TABLE alipay_logs OWNER TO bioerp;

--
-- Name: alipay_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE alipay_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alipay_logs_id_seq OWNER TO bioerp;

--
-- Name: alipay_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE alipay_logs_id_seq OWNED BY alipay_logs.id;


--
-- Name: amounts; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE amounts (
    id integer NOT NULL,
    amount money DEFAULT 0,
    order_id integer,
    original_amount money
);


ALTER TABLE amounts OWNER TO bioerp;

--
-- Name: amounts_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE amounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE amounts_id_seq OWNER TO bioerp;

--
-- Name: amounts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE amounts_id_seq OWNED BY amounts.id;


--
-- Name: bills; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE bills (
    id integer NOT NULL,
    user_id integer,
    order_id integer,
    sub_user_id integer,
    g_sub_user_id integer,
    volume money,
    type integer,
    reason integer,
    create_time timestamp without time zone DEFAULT now(),
    pay_amt_without_post_fee money DEFAULT 0
);


ALTER TABLE bills OWNER TO bioerp;

--
-- Name: bills_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE bills_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bills_id_seq OWNER TO bioerp;

--
-- Name: bills_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE bills_id_seq OWNED BY bills.id;


--
-- Name: captcha; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE captcha (
    captcha_id integer NOT NULL,
    ip_address character varying(16) DEFAULT '0'::character varying NOT NULL,
    word character varying(20) NOT NULL,
    captcha_time integer
);


ALTER TABLE captcha OWNER TO bioerp;

--
-- Name: captcha_captcha_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE captcha_captcha_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE captcha_captcha_id_seq OWNER TO bioerp;

--
-- Name: captcha_captcha_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE captcha_captcha_id_seq OWNED BY captcha.captcha_id;


--
-- Name: cart_product; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE cart_product (
    id integer NOT NULL,
    user_id integer,
    product_id integer,
    quantity integer,
    is_finished boolean DEFAULT false
);


ALTER TABLE cart_product OWNER TO bioerp;

--
-- Name: cart_product_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE cart_product_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cart_product_id_seq OWNER TO bioerp;

--
-- Name: cart_product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE cart_product_id_seq OWNED BY cart_product.id;


--
-- Name: coupons; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE coupons (
    id integer NOT NULL,
    user_id integer,
    create_time timestamp without time zone DEFAULT now(),
    active_time timestamp without time zone,
    order_id integer,
    volume money,
    is_active boolean DEFAULT false
);


ALTER TABLE coupons OWNER TO bioerp;

--
-- Name: coupons_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE coupons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE coupons_id_seq OWNER TO bioerp;

--
-- Name: coupons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE coupons_id_seq OWNED BY coupons.id;


--
-- Name: finish_log; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE finish_log (
    order_id integer,
    pay_amt money,
    user_id integer,
    g_parent_user_id integer,
    parent_user_id integer,
    pay_amt_without_post_fee money,
    is_first boolean,
    id integer NOT NULL
);


ALTER TABLE finish_log OWNER TO bioerp;

--
-- Name: finish_log_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE finish_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE finish_log_id_seq OWNER TO bioerp;

--
-- Name: finish_log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE finish_log_id_seq OWNED BY finish_log.id;


--
-- Name: forecasts; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE forecasts (
    id integer NOT NULL,
    content character varying,
    create_time timestamp without time zone DEFAULT now()
);


ALTER TABLE forecasts OWNER TO bioerp;

--
-- Name: forecasts_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE forecasts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE forecasts_id_seq OWNER TO bioerp;

--
-- Name: forecasts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE forecasts_id_seq OWNED BY forecasts.id;


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE jobs (
    id integer NOT NULL,
    user_id integer NOT NULL,
    return_profit money,
    order_id integer,
    is_expired boolean DEFAULT false NOT NULL,
    is_success boolean DEFAULT false NOT NULL,
    create_time timestamp without time zone DEFAULT now() NOT NULL,
    excute_time timestamp without time zone NOT NULL
);


ALTER TABLE jobs OWNER TO bioerp;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE jobs_id_seq OWNER TO bioerp;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE jobs_id_seq OWNED BY jobs.id;


--
-- Name: order_product; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE order_product (
    id integer NOT NULL,
    order_id integer,
    product_id integer,
    quantity integer
)
WITH (autovacuum_enabled=true);


ALTER TABLE order_product OWNER TO bioerp;

--
-- Name: order_product_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE order_product_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE order_product_id_seq OWNER TO bioerp;

--
-- Name: order_product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE order_product_id_seq OWNED BY order_product.id;


--
-- Name: orders; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE orders (
    id integer NOT NULL,
    user_id integer,
    create_time timestamp without time zone DEFAULT now(),
    update_time timestamp without time zone,
    is_pay boolean DEFAULT false,
    pay_amt money DEFAULT 0,
    is_correct boolean DEFAULT false,
    is_cancelled boolean DEFAULT false,
    is_deleted boolean DEFAULT false,
    pay_time timestamp without time zone,
    address_book_id integer,
    is_post boolean,
    post_fee money,
    finish_time timestamp without time zone,
    is_pay_online boolean DEFAULT false,
    is_first boolean DEFAULT false,
    pay_amt_without_post_fee money,
    is_valid boolean DEFAULT true,
    pay_method character varying DEFAULT 'offline'::character varying,
    trade_no character varying,
    post_info character varying,
    return_profit money DEFAULT 0,
    p_return_profit money DEFAULT 0,
    gp_return_profit money DEFAULT 0,
    p_return_invite money DEFAULT 0,
    original_amount money,
    profit_potential integer,
    is_confirmed boolean DEFAULT false,
    coupon_volume money DEFAULT '$0.00'::money,
    cash_volume money DEFAULT '$0.00'::money,
    has_coupon_volume boolean DEFAULT false,
    is_finished boolean DEFAULT false
);


ALTER TABLE orders OWNER TO bioerp;

--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE orders_id_seq OWNER TO bioerp;

--
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE orders_id_seq OWNED BY orders.id;


--
-- Name: post_rules; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE post_rules (
    id integer NOT NULL,
    province_id integer,
    city_id integer,
    first_pay money,
    additional_pay money,
    first_weight integer,
    additional_weight integer
);


ALTER TABLE post_rules OWNER TO bioerp;

--
-- Name: post_rules_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE post_rules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE post_rules_id_seq OWNER TO bioerp;

--
-- Name: post_rules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE post_rules_id_seq OWNED BY post_rules.id;


--
-- Name: price; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE price (
    id integer NOT NULL,
    product_id integer,
    price money DEFAULT 0.00,
    discount_price money
);


ALTER TABLE price OWNER TO bioerp;

--
-- Name: price_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE price_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE price_id_seq OWNER TO bioerp;

--
-- Name: price_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE price_id_seq OWNED BY price.id;


--
-- Name: product_amount; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE product_amount (
    id integer NOT NULL,
    product_id integer,
    order_id integer,
    amount money,
    quantity integer,
    original_amount money
);


ALTER TABLE product_amount OWNER TO bioerp;

--
-- Name: product_amount_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE product_amount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE product_amount_id_seq OWNER TO bioerp;

--
-- Name: product_amount_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE product_amount_id_seq OWNED BY product_amount.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE products (
    id integer NOT NULL,
    title character varying,
    properties character varying,
    feature character varying,
    usage_method character varying,
    ingredient character varying,
    img character varying,
    create_time timestamp without time zone DEFAULT now(),
    sale_time timestamp without time zone,
    off_sale_time timestamp without time zone,
    is_valid boolean,
    category integer DEFAULT 0 NOT NULL,
    weight integer DEFAULT 0 NOT NULL,
    thumb character varying,
    discount integer DEFAULT 60
);


ALTER TABLE products OWNER TO bioerp;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE products_id_seq OWNER TO bioerp;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE products_id_seq OWNED BY products.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE users (
    username character varying(16),
    password character(32),
    create_time timestamp without time zone DEFAULT now(),
    update_time timestamp without time zone,
    is_valid boolean,
    name character varying(10),
    citizen_id character varying(20),
    mobile_no character varying(15),
    wechat_id character varying(30),
    qq_no character varying(20),
    property money,
    lft integer NOT NULL,
    rgt integer NOT NULL,
    pid integer,
    profit money DEFAULT 0.00,
    id integer NOT NULL,
    first_purchase money DEFAULT 0,
    turnover money DEFAULT 0,
    initiation boolean DEFAULT false,
    current_bill_id integer,
    dept integer DEFAULT 1 NOT NULL,
    balance money DEFAULT '$0.00'::money,
    withdraw_volume money DEFAULT '$0.00'::money,
    real_balance money DEFAULT '$0.00'::money,
    active_coupon money DEFAULT '$0.00'::money,
    coupon_volume money DEFAULT '$0.00'::money,
    inactivated_coupon money DEFAULT '$0.00'::money,
    bank_info character varying,
    CONSTRAINT users_check CHECK ((lft < rgt)),
    CONSTRAINT users_lft_check CHECK ((lft > 0)),
    CONSTRAINT users_rgt_check CHECK ((rgt > 1))
);


ALTER TABLE users OWNER TO bioerp;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO bioerp;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: withdraw_logs; Type: TABLE; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE TABLE withdraw_logs (
    id integer NOT NULL,
    user_id integer,
    volume money,
    balance_before money,
    create_time timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE withdraw_logs OWNER TO bioerp;

--
-- Name: withdraw_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: bioerp
--

CREATE SEQUENCE withdraw_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE withdraw_logs_id_seq OWNER TO bioerp;

--
-- Name: withdraw_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bioerp
--

ALTER SEQUENCE withdraw_logs_id_seq OWNED BY withdraw_logs.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY address_books ALTER COLUMN id SET DEFAULT nextval('address_books_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY admins ALTER COLUMN id SET DEFAULT nextval('admins_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY alipay_logs ALTER COLUMN id SET DEFAULT nextval('alipay_logs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY amounts ALTER COLUMN id SET DEFAULT nextval('amounts_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY bills ALTER COLUMN id SET DEFAULT nextval('bills_id_seq'::regclass);


--
-- Name: captcha_id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY captcha ALTER COLUMN captcha_id SET DEFAULT nextval('captcha_captcha_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY cart_product ALTER COLUMN id SET DEFAULT nextval('cart_product_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY coupons ALTER COLUMN id SET DEFAULT nextval('coupons_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY finish_log ALTER COLUMN id SET DEFAULT nextval('finish_log_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY forecasts ALTER COLUMN id SET DEFAULT nextval('forecasts_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY jobs ALTER COLUMN id SET DEFAULT nextval('jobs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY order_product ALTER COLUMN id SET DEFAULT nextval('order_product_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY orders ALTER COLUMN id SET DEFAULT nextval('orders_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY post_rules ALTER COLUMN id SET DEFAULT nextval('post_rules_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY price ALTER COLUMN id SET DEFAULT nextval('price_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY product_amount ALTER COLUMN id SET DEFAULT nextval('product_amount_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY products ALTER COLUMN id SET DEFAULT nextval('products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY withdraw_logs ALTER COLUMN id SET DEFAULT nextval('withdraw_logs_id_seq'::regclass);


--
-- Data for Name: address_books; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO address_books VALUES (26, 15, '刘小浩', 1, 2, '', '', '2016-05-11 16:10:54.09259', '13642724255');
INSERT INTO address_books VALUES (27, 16, '朱经理', 1, 2, '', '', '2016-05-11 16:11:51.827363', '13234535466');
INSERT INTO address_books VALUES (28, 17, '蓝小樟', 1, 2, '', '', '2016-05-11 16:12:44.847793', '13234535466');
INSERT INTO address_books VALUES (29, 18, '候小丽', 1, 2, '', '', '2016-05-11 16:13:35.879595', '13556061457');
INSERT INTO address_books VALUES (30, 19, '测试', 21, 22, '', '无', '2017-10-17 17:23:46.132243', '13631799920');


--
-- Name: address_books_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('address_books_id_seq', 30, true);


--
-- Data for Name: admins; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO admins VALUES (1, 'adminlo             ', '31d6b5a10b1ecd8f1c28a6fef234f718', NULL);


--
-- Name: admins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('admins_id_seq', 1, false);


--
-- Data for Name: alipay_logs; Type: TABLE DATA; Schema: public; Owner: bioerp
--



--
-- Name: alipay_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('alipay_logs_id_seq', 1, false);


--
-- Data for Name: amounts; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO amounts VALUES (19, '$3,000.00', 21, '$5,000.00');
INSERT INTO amounts VALUES (20, '$4,800.00', 22, '$8,000.00');
INSERT INTO amounts VALUES (21, '$1,200.00', 23, '$2,000.00');
INSERT INTO amounts VALUES (22, '$1,800.00', 24, '$3,000.00');
INSERT INTO amounts VALUES (23, '$3,000.00', 25, '$5,000.00');
INSERT INTO amounts VALUES (24, '$5,400.00', 26, '$9,000.00');
INSERT INTO amounts VALUES (25, '$6,000.00', 27, '$10,000.00');
INSERT INTO amounts VALUES (26, '$4,800.00', 28, '$8,000.00');
INSERT INTO amounts VALUES (27, '$3,000.00', 29, '$5,000.00');


--
-- Name: amounts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('amounts_id_seq', 27, true);


--
-- Data for Name: bills; Type: TABLE DATA; Schema: public; Owner: bioerp
--



--
-- Name: bills_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('bills_id_seq', 1, false);


--
-- Data for Name: captcha; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO captcha VALUES (1424, '123.125.71.51', '32916', 1508544562);
INSERT INTO captcha VALUES (1427, '140.205.225.188', '98750', 1508572082);
INSERT INTO captcha VALUES (1421, '183.234.57.135', '96072', 1508503425);
INSERT INTO captcha VALUES (1425, '140.205.225.188', '45863', 1508572081);
INSERT INTO captcha VALUES (1428, '140.205.225.188', '47651', 1508572082);
INSERT INTO captcha VALUES (1422, '183.234.57.135', '19562', 1508503435);
INSERT INTO captcha VALUES (1426, '140.205.225.188', '17824', 1508572082);
INSERT INTO captcha VALUES (1423, '47.90.86.206', '26173', 1508505076);


--
-- Name: captcha_captcha_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('captcha_captcha_id_seq', 1428, true);


--
-- Data for Name: cart_product; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO cart_product VALUES (33, 19, 6, 1, false);


--
-- Name: cart_product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('cart_product_id_seq', 33, true);


--
-- Data for Name: coupons; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO coupons VALUES (22, 15, '2016-05-11 16:14:41.633334', '2016-06-01 00:00:00', 25, '$120.00', true);
INSERT INTO coupons VALUES (23, 16, '2016-05-11 16:14:51.418037', '2016-06-01 00:00:00', 26, '$216.00', true);
INSERT INTO coupons VALUES (24, 17, '2016-05-11 16:15:00.116933', '2016-06-01 00:00:00', 27, '$240.00', true);
INSERT INTO coupons VALUES (25, 17, '2016-05-11 16:15:00.116933', '2016-06-01 00:00:00', 27, '$120.00', true);
INSERT INTO coupons VALUES (26, 18, '2016-05-11 16:15:10.309158', '2016-06-01 00:00:00', 28, '$192.00', true);
INSERT INTO coupons VALUES (27, 18, '2016-05-11 16:15:10.309158', '2016-06-01 00:00:00', 28, '$96.00', true);


--
-- Name: coupons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('coupons_id_seq', 27, true);


--
-- Data for Name: finish_log; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO finish_log VALUES (25, '$3,000.00', 15, 0, 1, '$3,000.00', true, 13);
INSERT INTO finish_log VALUES (26, '$5,400.00', 16, 0, 1, '$5,400.00', true, 14);
INSERT INTO finish_log VALUES (27, '$6,000.00', 17, 1, 15, '$6,000.00', true, 15);
INSERT INTO finish_log VALUES (28, '$4,800.00', 18, 15, 17, '$4,800.00', true, 16);


--
-- Name: finish_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('finish_log_id_seq', 16, true);


--
-- Data for Name: forecasts; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO forecasts VALUES (1, '系统测试中......

system testing......', '2016-04-10 09:29:54.704556');


--
-- Name: forecasts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('forecasts_id_seq', 1, false);


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: bioerp
--



--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('jobs_id_seq', 4, true);


--
-- Data for Name: order_product; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO order_product VALUES (29, 25, 6, 5);
INSERT INTO order_product VALUES (30, 26, 6, 9);
INSERT INTO order_product VALUES (31, 27, 6, 10);
INSERT INTO order_product VALUES (32, 28, 6, 8);
INSERT INTO order_product VALUES (33, 29, 6, 5);


--
-- Name: order_product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('order_product_id_seq', 33, true);


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO orders VALUES (25, 15, '2016-05-11 16:10:54.09259', '2016-05-11 16:14:41', true, '$3,000.00', true, false, false, NULL, 26, false, '$0.00', '2016-05-11 16:14:41', false, true, '$3,000.00', true, 'offline', NULL, NULL, '$750.00', '$750.00', '$0.00', '$450.00', '$0.00', 20, true, '$0.00', '$3,000.00', false, true);
INSERT INTO orders VALUES (26, 16, '2016-05-11 16:11:51.827363', '2016-05-11 16:14:51', true, '$5,400.00', true, false, false, NULL, 27, false, '$0.00', '2016-05-11 16:14:51', false, true, '$5,400.00', true, 'offline', NULL, NULL, '$1,350.00', '$1,350.00', '$0.00', '$810.00', '$0.00', 20, true, '$0.00', '$5,400.00', false, true);
INSERT INTO orders VALUES (27, 17, '2016-05-11 16:12:44.847793', '2016-05-11 16:15:00', true, '$6,000.00', true, false, false, NULL, 28, false, '$0.00', '2016-05-11 16:15:00', false, true, '$6,000.00', true, 'offline', NULL, NULL, '$2,700.00', '$1,500.00', '$1,200.00', '$900.00', '$0.00', 0, true, '$0.00', '$6,000.00', false, true);
INSERT INTO orders VALUES (28, 18, '2016-05-11 16:13:35.879595', '2016-05-11 16:15:10', true, '$4,800.00', true, false, false, NULL, 29, false, '$0.00', '2016-05-11 16:15:10', false, true, '$4,800.00', true, 'offline', NULL, NULL, '$2,160.00', '$1,200.00', '$960.00', '$720.00', '$0.00', 0, true, '$0.00', '$4,800.00', false, true);
INSERT INTO orders VALUES (29, 19, '2017-10-17 17:23:46.132243', NULL, false, '$0.00', false, false, false, NULL, 30, false, '$0.00', NULL, false, true, NULL, true, 'alipay', NULL, NULL, '$0.00', '$0.00', '$0.00', '$0.00', NULL, NULL, true, '$0.00', '$0.00', false, false);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('orders_id_seq', 29, true);


--
-- Data for Name: post_rules; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO post_rules VALUES (1, 0, 0, '$12.00', '$2.00', 1000, 500);
INSERT INTO post_rules VALUES (5, 1963, 1964, '$8.00', '$2.00', 1200, 400);


--
-- Name: post_rules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('post_rules_id_seq', 5, true);


--
-- Data for Name: price; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO price VALUES (3, 6, '$1,000.00', '$600.00');


--
-- Name: price_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('price_id_seq', 3, true);


--
-- Data for Name: product_amount; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO product_amount VALUES (20, 6, 21, '$600.00', 5, '$1,000.00');
INSERT INTO product_amount VALUES (21, 6, 22, '$600.00', 8, '$1,000.00');
INSERT INTO product_amount VALUES (22, 6, 23, '$600.00', 2, '$1,000.00');
INSERT INTO product_amount VALUES (23, 6, 24, '$600.00', 3, '$1,000.00');
INSERT INTO product_amount VALUES (24, 6, 25, '$600.00', 5, '$1,000.00');
INSERT INTO product_amount VALUES (25, 6, 26, '$600.00', 9, '$1,000.00');
INSERT INTO product_amount VALUES (26, 6, 27, '$600.00', 10, '$1,000.00');
INSERT INTO product_amount VALUES (27, 6, 28, '$600.00', 8, '$1,000.00');
INSERT INTO product_amount VALUES (28, 6, 29, '$600.00', 5, '$1,000.00');


--
-- Name: product_amount_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('product_amount_id_seq', 28, true);


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO products VALUES (6, '台湾酵素', '350ML', '①：平衡内分泌，活化细胞，美容养颜。
②：提高身体免疫，增强身体抵抗力。', '冲水后直接饮用', '水果，蔬菜，牛樟芝', '/uploads/570a65d702c94.jpg', '2016-04-10 22:40:23.042642', NULL, NULL, true, 0, 1500, '/uploads/570a65d702c94_thumb.jpg', 60);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('products_id_seq', 6, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: bioerp
--

INSERT INTO users VALUES ('zhujingli', '01a0c0612632e84182c372c95f92b3f4', '2016-05-11 16:05:22.221341', NULL, true, '朱经理', '445381199010052237', '12381274892', '', '88944433', NULL, 14, 15, 1, '$0.00', 16, '$5,400.00', '$5,400.00', true, NULL, 2, '$0.00', '$0.00', '$0.00', '$216.00', '$0.00', '-$216.00', 'ABC 633300208304');
INSERT INTO users VALUES ('lanxiaozhang', '54a91301442e525da1d7e8dde61b576b', '2016-05-11 16:06:37.352497', NULL, true, '蓝小樟', '440182199911111119', '13655446622', '', '45663722', NULL, 9, 12, 15, '$1,920.00', 17, '$6,000.00', '$6,000.00', true, NULL, 3, '$1,920.00', '$0.00', '$1,728.00', '$360.00', '$192.00', '-$168.00', 'CMCC 227332342');
INSERT INTO users VALUES ('liuxiaohao', '05faffe5218382a536e9c811528b0dc0', '2016-05-11 16:04:18.379519', NULL, true, '刘小浩', '440101199912292259', '12381274891', 'wecha', '56748873', NULL, 8, 13, 1, '$3,360.00', 15, '$3,000.00', '$3,000.00', true, NULL, 2, '$3,360.00', '$0.00', '$3,024.00', '$120.00', '$336.00', '$216.00', 'CMCC 877777');
INSERT INTO users VALUES ('houxiaoli', 'f0b458fc2047bb264b24ecf6f2ac4399', '2016-05-11 16:07:51.49035', NULL, true, '候小丽', '440101199812292251', '12342345555', '', '77362228', NULL, 10, 11, 17, '$0.00', 18, '$4,800.00', '$4,800.00', true, NULL, 4, '$0.00', '$0.00', '$0.00', '$288.00', '$0.00', '-$288.00', 'ABC 620020333444');
INSERT INTO users VALUES ('yangbao', 'b4b8daf4b8ea9d39568719e1e320076f', '2016-04-10 09:36:09.978033', '2016-04-10 09:36:09.978033', true, '洋宝生物科技', '445381199010052237', '13642724255', '13642724255', '23008600', '$0.00', 1, 18, 0, '$4,560.00', 1, '$0.00', '$0.00', false, NULL, 1, '$4,560.00', '$0.00', '$4,104.00', '$0.00', '$456.00', '$456.00', '工商银行 62223339999222');
INSERT INTO users VALUES ('yilang', '25d55ad283aa400af464c76d713c07ad', '2017-10-17 17:22:07.505582', NULL, true, '叶小朗', '441900199010294310', '13631799920', '', '304669447', NULL, 16, 17, 1, '$0.00', 19, '$0.00', '$0.00', false, NULL, 2, '$0.00', '$0.00', '$0.00', '$0.00', '$0.00', '$0.00', '123');


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('users_id_seq', 19, true);


--
-- Data for Name: withdraw_logs; Type: TABLE DATA; Schema: public; Owner: bioerp
--



--
-- Name: withdraw_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bioerp
--

SELECT pg_catalog.setval('withdraw_logs_id_seq', 3, true);


--
-- Name: address_books_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY address_books
    ADD CONSTRAINT address_books_pkey PRIMARY KEY (id);


--
-- Name: alipay_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY alipay_logs
    ADD CONSTRAINT alipay_logs_pkey PRIMARY KEY (id);


--
-- Name: amounts_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY amounts
    ADD CONSTRAINT amounts_pkey PRIMARY KEY (id);


--
-- Name: bills_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY bills
    ADD CONSTRAINT bills_pkey PRIMARY KEY (id);


--
-- Name: captcha_id; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY captcha
    ADD CONSTRAINT captcha_id PRIMARY KEY (captcha_id);


--
-- Name: cart_product_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY cart_product
    ADD CONSTRAINT cart_product_pkey PRIMARY KEY (id);


--
-- Name: coupons_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY coupons
    ADD CONSTRAINT coupons_pkey PRIMARY KEY (id);


--
-- Name: finish_log_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY finish_log
    ADD CONSTRAINT finish_log_pkey PRIMARY KEY (id);


--
-- Name: forecast_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY forecasts
    ADD CONSTRAINT forecast_pkey PRIMARY KEY (id);


--
-- Name: id; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY admins
    ADD CONSTRAINT id PRIMARY KEY (id);


--
-- Name: jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: lft_check; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT lft_check UNIQUE (lft) DEFERRABLE;


--
-- Name: order_product_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY order_product
    ADD CONSTRAINT order_product_pkey PRIMARY KEY (id);


--
-- Name: orders_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: post_rules_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY post_rules
    ADD CONSTRAINT post_rules_pkey PRIMARY KEY (id);


--
-- Name: price_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY price
    ADD CONSTRAINT price_pkey PRIMARY KEY (id);


--
-- Name: product_amount_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY product_amount
    ADD CONSTRAINT product_amount_pkey PRIMARY KEY (id);


--
-- Name: products_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: rgt_check; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT rgt_check UNIQUE (rgt) DEFERRABLE;


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: withdraw_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: bioerp; Tablespace: 
--

ALTER TABLE ONLY withdraw_logs
    ADD CONSTRAINT withdraw_logs_pkey PRIMARY KEY (id);


--
-- Name: coupons_active_time_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX coupons_active_time_idx ON coupons USING btree (active_time);


--
-- Name: coupons_is_active_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX coupons_is_active_idx ON coupons USING btree (is_active);


--
-- Name: coupons_user_id_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX coupons_user_id_idx ON coupons USING btree (user_id);


--
-- Name: fki_cart_product_user_id_index; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX fki_cart_product_user_id_index ON cart_product USING btree (user_id);


--
-- Name: fki_orders_user_id_users_id; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX fki_orders_user_id_users_id ON orders USING btree (user_id);


--
-- Name: fki_product_amount_product_id_products_id; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX fki_product_amount_product_id_products_id ON product_amount USING btree (product_id);


--
-- Name: jobs_excute_time_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX jobs_excute_time_idx ON jobs USING btree (excute_time);


--
-- Name: order_product_order_id_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX order_product_order_id_idx ON order_product USING btree (order_id);


--
-- Name: price_product_id_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX price_product_id_idx ON price USING btree (product_id);


--
-- Name: users_lft_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX users_lft_idx ON users USING btree (lft);


--
-- Name: users_pid_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX users_pid_idx ON users USING btree (pid);


--
-- Name: users_rgt_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX users_rgt_idx ON users USING btree (rgt);


--
-- Name: withdraw_logs_user_id_idx; Type: INDEX; Schema: public; Owner: bioerp; Tablespace: 
--

CREATE INDEX withdraw_logs_user_id_idx ON withdraw_logs USING btree (user_id);


--
-- Name: cart_product_user_id_index; Type: FK CONSTRAINT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY cart_product
    ADD CONSTRAINT cart_product_user_id_index FOREIGN KEY (user_id) REFERENCES users(id);


--
-- Name: fk_product_amount_product_id_products_id; Type: FK CONSTRAINT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY product_amount
    ADD CONSTRAINT fk_product_amount_product_id_products_id FOREIGN KEY (product_id) REFERENCES products(id);


--
-- Name: orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id);


--
-- Name: price_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bioerp
--

ALTER TABLE ONLY price
    ADD CONSTRAINT price_product_id_fkey FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO bioerp;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

