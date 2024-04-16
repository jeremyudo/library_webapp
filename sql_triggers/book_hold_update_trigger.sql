DELIMITER //

CREATE TRIGGER after_books_available_update
AFTER UPDATE ON books
FOR EACH ROW
BEGIN
    DECLARE hold_id INT;
    DECLARE user_id INT;
    DECLARE notification_type ENUM('Holds', 'Events');

    SELECT HoldID, UserID INTO hold_id, user_id 
    FROM holds 
    WHERE ItemID = NEW.ISBN AND Status = 'pending'
    ORDER BY HoldID ASC
    LIMIT 1;

    IF hold_id IS NOT NULL THEN
        SET notification_type = 'Holds';

        INSERT INTO notifications (UserID, Message, NotificationType, ItemID)
        VALUES (user_id, CONCAT('You are first in line on the holds list and the book with ISBN ', NEW.ISBN, ' is now available to checkout.'), notification_type, NEW.ISBN); -- Use NEW.ISBN directly
    END IF;
END //

DELIMITER ;
