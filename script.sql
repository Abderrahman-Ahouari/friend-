create database gestion_salle_sport;
use  gestion_salle_sport;
drop table utilisateurs ;
drop table activites;
drop table reservations;
create table utilisateurs (
    id_utilisateur int primary key auto_increment ,
    nom varchar(50)  not null,
    prenom  varchar(50) not null,
    eamil  varchar(50) not null,
    telephone  varchar(15) not null,
    role  enum('membre','admin'),
    password varchar(100) not null      
);

create table activites ( 
    id_activite int primary key auto_increment,
    id_admin int not null,
    nom varchar(50) not null, 
    descriptionA text not null,
    capacite int  not null,
    date_debu DATE DEFAULT '2024/12/30',
    date_fin date,
    disponibilite ENUM('disponible', 'pasdisponible')  not null,
    constraint FK_admin foreign key (id_admin) references utilisateurs(id_utilisateur) on delete cascade on update cascade
);

create table reservations(
    id_reservation int primary key auto_increment,
    id_Membre int not null,
    id_activite int not null,       
    date_reservation  datetime default CURRENT_TIMESTAMP,
    statut enum('confirmee','annulee','encour') default 'encour',
    constraint FK_client foreign key (id_Membre) references utilisateurs(id_utilisateur) on delete cascade on update cascade,
    constraint FK_activite foreign key (id_activite) references activites(id_activite) on delete cascade on update cascade
);
insert into utilisateurs(nom,prenom,eamil,telephone,role,password)  
                values   
                     ('Doe', 'John', 'john.doe@example.com', '1234567890', 'membre', MD5('password123')),
                     ('lakroune', 'hamza', 'lakroune@gmail.com', '0954545', 'admin', MD5('12345'));
insert into activites(id_admin,nom,descriptionA,capacite,date_debu,date_fin,disponibilite) values
                     (1, 'Yoga', 'Description Yoga', 40, '2004-8-10', '2016-8-10','disponible' ),
                     (2, 'boxing', 'Description boxing', 35, '2004-5-25', '2016-10-15','pas disponible' );
insert into reservations(id_Membre,id_activite) values
                     (1,2),
                     (3,2);

-- Combien de réservations ont été confirmées dans le système
select count(*)
from reservations
where statut ='confirmee';
-- Quelle est la capacité moyenne des activités proposées
select avg(sum(capacite))
from  activites;
-- Combien de membres distincts ont effectué au moins une réservation
select  count(distinct id_Membre)
from reservations 
where statut ='confirmee'
-- Quelles sont les trois activités les plus réservées ?
select  a.*  ,count(r.id_activite) as nombre_reservations
from  activite  a , reservations r
where id_activite  = r.id_activite 
group  by  id_activite
order by nombre_reservations limit; 

