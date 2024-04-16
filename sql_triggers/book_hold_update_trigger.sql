DELIMITER //

CREATE TRIGGER after_lostitem_update
AFTER UPDATE ON lostitems
FOR EACH ROW
BEGIN
    DECLARE user_id BIGINT;
    DECLARE notification_type ENUM('LostItem');
    DECLARE message VARCHAR(255);

    SELECT UserID INTO user_id
    FROM lostitems
    ORDER BY LostID ASC
    LIMIT 1;

    SET message = CONCAT(user_id, ' marked item ', NEW.ItemID, ' as lost and will be charged a $', NEW.Fine, ' fee');

    IF user_id IS NOT NULL THEN
        INSERT INTO staff_notifications (ItemID, NotificationType, Message, UserID, MarkedAsRead, TimeStamp)
        VALUES (NEW.ItemID, 'LostItem', message, user_id, FALSE, CURRENT_TIMESTAMP);
    END IF;
END //

DELIMITER ;