introduction:



this is a system of categories that have nested relationships
as each category has a parent category or no
also each category has a lower level categories or no


also there are products that each product  can belongs to  multiple categories
so the relation between categories and products is (many to many)


also there is reviews table
as each product may be has many reviews or not
so relationship is (one to many) between product and reviews


also there is  an advanced filter function
as you can filter the product by its name or description or price
or any other category or lower or higher level categories names
by its relation
by only the parameter filter
or you can make no filter and get all products list
when you set the filter parameter to be null
in search function in ProductController








CategoryController


index function
      get all category with its parent category and its children categories
      the pagination variable is in the env file


show function
      check if Category is found or no  after that
      show unique products   from   category and sub categories and parent category
      and also show these categories


store function
    store new category
    and attach it to another   category   to be parent category or make parent id null that means has no parent category

delete function
         * first check if the category is found or no
         * then check
         * if the category has childern or no if no so you can not delete
         *  until delete those children first
         * *
         * then check
         * if the category has products or no if no so you can not delete
         *  until delete those products first




###############################################################################################

ProductController

search function
        here you can search by  name of category or sub category  or any category has relation with that product
        or by name of product or by description of product  or by price of product or
        if you want make no parameter for search it will get all products list
        so it is optional to make filter or no
        also appends() method that i used is refer to apply
        this function always to the other pagination links with the same filter parameter


show function
        here you can show the product with its categories  as the relationship between products and categories is many to many
        as each product can be belongs to multiple categories



store function
    here you can add new product
     name ,description ,price
     then   attach this product
     to a category or multiple categories (array of categories = $request->category_id) as you want


update function
    here you can update product and sync this product to a category
    or multiple categories as this function is making detaching first then making attaching for ($request->category_id) array


destroy function
    delete the product



###############################################################################################


ReviewController



index function
    get a product with its reviews in descinding order if this product has reviews
    if no it will show the product with ths message 'there is no reviews yet'


store function
    store review to a certain product
    as follow :
    title, body, rating(1 to 5)

show function
    show a certain product with a certain review
    by two parameters : product_id , review_id

update function
        update a certain     review
        by two parameters : product_id , review_id

destroy function
        delete a certain     review
        by two parameters : product_id , review_id
