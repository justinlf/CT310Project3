DROP TABLE IF EXISTS messages;

CREATE TABLE messages(
	mid INTEGER PRIMARY KEY AUTOINCREMENT,
	type VARCHAR(10),
	sender VARCHAR(50) NOT NULL,
	receiver VARCHAR(50) NOT NULL,
	time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	message TEXT,
	parent INTEGER,
	FOREIGN KEY(sender) REFERENCES users(username),
	FOREIGN KEY(receiver) REFERENCES users(username),
	FOREIGN KEY(parent) REFERENCES messages(mid)
);
