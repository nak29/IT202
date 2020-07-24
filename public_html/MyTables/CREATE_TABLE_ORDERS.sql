CREATE TABLE Orders(
    id int auto_increment,
    order_id int,
    product_id int,
    user_id int,
    quantity int,
    address varchar(120) NOT NULL,
    subtotal decimal(10,2),
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key(id),
    foreign key(product_id) references Products(id),
    foreign key(user_id) references Users(id)
)