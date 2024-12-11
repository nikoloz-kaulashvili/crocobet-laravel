# პროექტის დასახელება
crocobet-laravel
## 📖 პროექტის აღწერა

ეს არის RESTful API პროექტი, რომელიც აგებულია Laravel-ზე და მოიცავს მომხმარებლის ავთენტიფიკაციის, ტოკენების გენერაციისა და სხვა დაკავშირებული ფუნქციების მართვას. პროექტი იყენებს სხვადასხვა საშუალებებს, რათა უზრუნველყოს API-ს უსაფრთხო და მოქნილი მართვა.

## 🚀 ფუნქციონალები

**მომხმარებლის ავთენტიფიკაცია**:
  - უსაფრთხო რეგისტრაცია და ავტორიზაცია.
  - ტოკენზე დაფუძნებული ავთენტიფიკაცია Laravel-ის guard სისტემით.
**ტოკენების მართვა**:
  - ტოკენების შექმნა, და წაშლა.
  - policy ტოკენების უსაფრთხო წაშლისთვის.
**Middleware ინტეგრაცია**:
  - მოთხოვნების ლოგირების Middleware მომხმარებლის რექვესთების დასალოგად.
**როლებისა და უფლებების კონტროლი**:
  - ავტორიზაცია Gates და Policies გამოყენებით.
**Unit და Feature ტესტირება**:
  - ავტორიზაცია რეგისტრაციის ტესტირება.


**წინაპირობები**
- PHP 8.1 ან უფრო მაღალი ვერსია
- Composer
- MySQL 
- Node.js და npm 

**პროექტის გაშვების ნაბიჯები**

1. **გააკლონეთ რეპოზიტორია**:
   - git clone https://github.com/nikoloz-kaulashvili/crocobet-laravel.git
   - cd crocobet-laravel
   - composer install
   - npm install
   - php artisan migrate
   - php artisan serve

# API დოკუმენტაცია

## 📖 მომხმარებლის ავთენტიფიკაცია

### რეგისტრაცია
- **მეთოდი:** `POST`
- **URL:** `/api/register`
- **მონაცემები:**

  {
    "name": "სახელი გვარი",
    "email": "example@example.com",
    "password": "password"
  }

- **პასუხის სტრუქტურა წარმატების შემთხვევაში:**

  {
    "message": "User registered successfully",
    "user": {
      "id": 1,
      "name": "სახელი გვარი",
      "email": "example@example.com"
    }
  }

---

### ავტორიზაცია
- **მეთოდი:** `POST`
- **URL:** `/api/login`
- **მონაცემები:**

  {
    "email": "example@example.com",
    "password": "password"
  }

- **პასუხის სტრუქტურა წარმატების შემთხვევაში:**

  {
    "token": "access_token",
    "user": {
      "id": 1,
      "name": "სახელი გვარი",
      "email": "example@example.com"
    }
  }

- **პასუხის სტრუქტურა შეცდომის შემთხვევაში:**

  {
    "message": "Invalid credentials"
  }

---

## 🎟️ ტოკენების მართვა

### ტოკენის შექმნა
- **მეთოდი:** `POST`
- **URL:** `/api/tokens`
- **ავტორიზაცია:** `Bearer {access_token}`
- **პასუხის სტრუქტურა:**

  {
    "id": 1,
    "user_id": 1,
    "access_token": "sample-token",
    "expires_at": "2024-01-01 00:00:00"
  }

---

### ტოკენის წაშლა
- **მეთოდი:** `DELETE`
- **URL:** `/api/tokens/{id}`
- **ავტორიზაცია:** `Bearer {access_token}`
- **პასუხის სტრუქტურა წარმატების შემთხვევაში:**

  {
    "message": "Token deleted successfully"
  }

- **პასუხის სტრუქტურა შეცდომის შემთხვევაში:**

  {
    "message": "Unauthorized"
  }




