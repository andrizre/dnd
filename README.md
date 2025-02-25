# Dungeon RPG Game

A web-based RPG game built with PHP, MySQL, Tailwind CSS, and jQuery.

## Features

- User authentication system
- Character creation and management
- Quest system
- Battle system
- Experience and gold progression
- Profile management

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- mod_rewrite enabled

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/dungeon-rpg.git
```

2. Import the database structure:
```bash
mysql -u your_username -p your_database < database.sql
```

3. Configure the database connection in `config/database.php`

4. Ensure the web server has write permissions to the required directories:
```bash
chmod 755 assets/
chmod 755 uploads/
```

5. Configure your web server to point to the project directory

## Directory Structure

```
dungeon-rpg/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── config/
├── includes/
├── layouts/
└── README.md
```

## Security

- All user passwords are hashed using PHP's password_hash()
- SQL injection prevention using PDO prepared statements
- XSS protection through proper output escaping
- CSRF protection on forms

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.