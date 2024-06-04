# Membuat REST API data desa di Indonesia

Menggunakan Framework CodeIgniter 3
dengan menggunakan library dari https://github.com/ardisaurus/ci-restserver
REST API Documentation

## Base URL

http://localhost/desa/

## Endpoints

### 1. Get All Desa

**URL:** `api/desa`

**Method:** `GET`

**Success Response:**

```json
{
    "status": 200,
    "error": false,
    "message": "Data berhasil diambil.",
    "data": [
        {
            "id": 1,
            "district_id": "1101",
            "name": "Tegal"
        },
        ...
    ]
}
```

### 2. Get All Desa

**URL:** `api/desa/{id}`

**Method:** `GET`

URL Parameters:

- id (integer): ID of the desa to retrieve.

**Success Response:**

```json
{
	"status": 200,
	"error": false,
	"message": "Data berhasil diambil.",
	"data": [
		{
			"id": 1,
			"district_id": "1101",
			"name": "Tegal"
		}
	]
}
```

**Error Response:**

```json
{
	"status": 404,
	"error": true,
	"message": "Data tidak ditemukan.",
	"data": null
}
```

### 3. Post Desa

**URL:** `api/desa`

**Method:** `POST`

Request Body:

```json
{
	"id": "1",
	"district_id": "1101",
	"name": "Tegal"
}
```

**Success Response:**

```json
{
	"status": 200,
	"error": false,
	"message": "Data berhasil disimpan.",
	"data": {
		"id": 1,
		"district_id": "1101",
		"name": "Tegal"
	}
}
```

**Error Response:**

```json
{
	"status": 400,
	"error": true,
	"message": [
		"district_id tidak boleh kosong",
		"district_id harus berupa angka"
	],
	"data": null
}
```

### 4. Put Desa

**URL:** `api/desa/{id}`

**Method:** `PUT`

URL Parameters:

- id (integer): ID of the desa to retrieve.

Request Body:

```json
{
	"district_id": "1101",
	"name": "Tegal"
}
```

**Success Response:**

```json
{
	"status": 200,
	"error": false,
	"message": "Data berhasil diubah.",
	"data": {
		"id": 1,
		"district_id": "1101",
		"name": "Tegal"
	}
}
```

**Error Response:**

```json
{
	"status": 400,
	"error": true,
	"message": [
		"district_id tidak boleh kosong",
		"district_id harus berupa angka"
	],
	"data": null
}
```

### 5. Delete Desa

**URL:** `api/desa/{id}`

**Method:** `DELETE`

URL Parameters:

- id (integer): ID of the desa to retrieve.

**Success Response:**

```json
{
	"status": 200,
	"error": false,
	"message": "Data berhasil dihapus.",
	"data": null
}
```

**Error Response:**

```json
{
	"status": 404,
	"error": true,
	"message": "Data tidak ditemukan.",
	"data": null
}
```
