CREATE TABLE Users(
    id int auto_increment,
    email varchar(100) unique,
    first_name varchar(100),
    last_name varchar(100),
    password varchar(100),
    created created default current_timestamp ,
    modified modified default current_timestamp on update current_timestamp,
    primary key(id),
)