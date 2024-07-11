# Project Title

## Introduction

This is a system of categories that have nested relationships:
- Each category has a parent category or none.
- Each category can have lower level categories or none.

Additionally, there are products that each can belong to multiple categories. The relationship between categories and products is many-to-many.

There is also a reviews table:
- Each product may have many reviews or none. 
- The relationship is one-to-many between products and reviews.

An advanced filter function allows you to filter products by:
- Name
- Description
- Price
- Any category (including lower or higher level categories)

You can filter by only the parameter or make no filter to get all products by setting the filter parameter to null in the search function in `ProductController`.

## CategoryController

### index Function
- Retrieves all categories with their parent category and children categories.
- The pagination variable is in the `.env` file.

### show Function
- Checks if the category is found or not.
- Shows unique products from the category, sub-categories, and parent category.
- Also shows these categories.

### store Function
- Stores a new category.
- Attaches it to another category to be a parent category or sets parent ID to null (indicating no parent category).

### delete Function
- First checks if the category is found or not.
- Then checks:
  - If the category has children or not. If yes, it cannot be deleted until those children are deleted first.
  - If the category has products or not. If yes, it cannot be deleted until those products are deleted first.

## ProductController

### search Function
- Allows searching by:
  - Name of category or sub-category.
  - Any category related to that product.
  - Name, description, or price of the product.
- If no parameters are provided, it will get all products.
- The `appends()` method applies the same filter parameter to other pagination links.

### show Function
- Shows the product with its categories, as the relationship between products and categories is many-to-many.

### store Function
- Adds a new product with name, description, and price.
- Attaches this product to a category or multiple categories (array of categories).

### update Function
- Updates a product and syncs it to a category or multiple categories by detaching first and then attaching.

### destroy Function
- Deletes the product.

## ReviewController

### index Function
- Retrieves a product with its reviews in descending order.
- If the product has no reviews, it shows the product with the message 'there are no reviews yet'.

### store Function
- Stores a review for a certain product with:
  - Title
  - Body
  - Rating (1 to 5)

### show Function
- Shows a certain product with a certain review by two parameters: `product_id` and `review_id`.

### update Function
- Updates a certain review by two parameters: `product_id` and `review_id`.

### destroy Function
- Deletes a certain review by two parameters: `product_id` and `review_id`.
