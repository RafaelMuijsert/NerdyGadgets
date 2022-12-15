USE nerdygadgets;
ALTER TABLE webshop_order
    ADD orderStatus VARCHAR(64) DEFAULT 'Bestelling wordt verwerkt.';


USE nerdygadgets;
ALTER TABLE webshop_order
    ADD userID INT;

-- CREATE RULE update_order_status AS
--     ON UPDATE TO webshop_order
--        WHERE (NEW.datum < NOW() - INTERVAL 2 DAY) AND (NEW.orderStatus != 'Bezorgd')
--            DO UPDATE SET orderStatus = 'Bezorgd';