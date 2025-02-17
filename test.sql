CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_number` varchar(10) NOT NULL,
  `sl_no` varchar(20) DEFAULT NULL,
  `status` enum('checked_in','checked_out') NOT NULL DEFAULT 'checked_in',
  `checkin_date` datetime DEFAULT NULL,
  `checkout_date` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `aadhar_no` varchar(100) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL,
  `documents` TEXT DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  FOREIGN KEY (`room_number`) REFERENCES `rooms`(`room_number`),
  PRIMARY KEY (`id`)
)


SELECT 
    r.room_number, 
    r.category, 
    r.floor, 
    book.id,
    book.name
FROM 
    rooms r
LEFT JOIN 
    bookings book ON r.room_number = book.room_number AND book.status = 'checked_in'
ORDER BY 
    r.floor ASC, r.room_number ASC;