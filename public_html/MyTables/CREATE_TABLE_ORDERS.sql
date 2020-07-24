CREATE TABLE Orders(
    id int auto_increment,
    product_id int,
    user_id int,
    cart_id int,
    address varchar(120) NOT NULL,
    created datetime default current_timestamp ,
    modified datetime default current_timestamp on update current_timestamp,
    primary key(id),
    foreign key(product_id) references Products.id,
    foreign key(user_id) references Users.id,
    foreign key(cart_id) references Cart.id
)