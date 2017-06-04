# Fresh Pizza Delivery

This project is built by following technologies:

* Laravel 5.4
* PHP 7.1


It also contains a git repository. The first commit is "Init Laravel", and the second commit is my code.

It is a RESTful API server. For demonstration purpose, I don't use any authentication in this server. It means anyone can call these following APIs without being asked permission.

The DB schema can be seen at:
`./schema.png`

### Scenario

#### User Side
A user opens freshpizzadelivery.com, we need to get all of pizzas we have by this API:

```
GET /pizzas
```

The user chooses some pizzas he likes, then makes an order. Before he can submit his order, he is required to fill a form of his name, address, phone and note. When he clicks on submit button, the app will call following API:

```
POST /api/pizzas
```

with data is customer's name, address, phone, note and an array of ids of pizzas he ordered.

#### Admin Side
An administrator has a different app for management. He can create new kind of pizza by:

```
POST /api/pizzas
```

He also can see the list of unprocessed orders by:

```
GET /api/orders?status=new
```

Then he picks an order, process this order and when he starts develivering this order, he can update the status of the order to `delivering` by:

```
PATCH /api/orders/{order_id}
```

with data is `status=delivering`

After delievered successfully to customer home and get cash as payment, the admin can update the status of the order to `completed` by:

```
PATCH /api/orders/{order_id}
```

with data is `status=completed`
