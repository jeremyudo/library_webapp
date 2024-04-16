DELIMITER $$

CREATE TRIGGER lostitem_after_insert
AFTER INSERT ON lostitems
FOR EACH ROW
BEGIN
    DECLARE item_type VARCHAR(50);
    DECLARE message VARCHAR(255);
    
    IF NEW.ItemType = 'Book' THEN
        SET item_type := 'Book';
    ELSE
        SET item_type := 'DigitalItem';
    END IF;
    
    SET message := CONCAT('User ', NEW.UserID, ' marked item ', NEW.ItemID, ' as lost and will be charged a $', NEW.Fine, ' fee');
    
    INSERT INTO staff_notifications (ItemID, NotificationType, Message, UserID, MarkedAsRead, TimeStamp)
    VALUES (NEW.ItemID, item_type, message, NEW.UserID, FALSE, NOW());
END$$

DELIMITER ;
