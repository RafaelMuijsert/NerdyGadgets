USE nerdygadgets;
ALTER TABLE webshop_order
    ADD orderStatus VARCHAR(64) DEFAULT 'Bestelling wordt verwerkt.';


USE nerdygadgets;
ALTER TABLE webshop_order
    ADD userID INT;

CREATE TRIGGER update_order_status
    AFTER UPDATE ON webshop_order
    FOR EACH ROW
BEGIN
    UPDATE webshop_order
    SET orderStatus = 'Bezorgd'
    WHERE NOW() > DATE_ADD(datum, INTERVAL 2 DAY);
END;
