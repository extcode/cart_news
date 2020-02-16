#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
    sku varchar(255) DEFAULT '' NOT NULL,
    price double(11,2) DEFAULT '0.00' NOT NULL,
    tax_class_id int(11) unsigned DEFAULT '1' NOT NULL,
);
