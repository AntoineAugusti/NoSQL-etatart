SELECT c.id, c.content, c.quote_id, c.user_id, c.created_at,
u.id u_id, u.login u_login, u.avatar u_avatar, 
u.notification_comment_quote u_notification_comment_quote, u.security_level u_security_level,
q.id q_id, q.content q_content, q.user_id q_user_id, q.approved q_approved, 
q.created_at q_created_at,
COUNT(c2.id) AS total_comments,
(COUNT(fav.id) >= 1) AS is_favorite
FROM comments c
LEFT JOIN users u
ON c.user_id = u.id
LEFT JOIN quotes q
ON c.quote_id = q.id
LEFT JOIN favorite_quotes fav
ON c.quote_id = fav.quote_id AND fav.user_id = 42
LEFT JOIN comments c2
ON c2.quote_id = c.quote_id
WHERE c.id = 1500
GROUP BY c2.quote_id