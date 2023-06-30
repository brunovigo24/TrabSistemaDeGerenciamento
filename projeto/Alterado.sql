create database LabProject;
use LabProject;

create table Colaboradores(
	id int primary key auto_increment,
    nome varchar(45),
    cargo varchar(45),
    cpf varchar(45)
);
create table Projetos(
	id int primary key auto_increment,
    nome varchar(45),
    descricao longtext,
    responsavel int,
    dataInicio date
);

create table Tarefas(
	id int primary key auto_increment,
    nome varchar(45),
    descricao longtext,
    prazo int,
    projeto int,
    responsavel int
);

alter table Projetos add constraint fk_responsavel_G foreign key (responsavel) references Colaboradores (id);
alter table Tarefas add constraint fk_projetos foreign key (projeto) references Projetos(id);
alter table Tarefas add constraint fk_responsavel_C foreign key (responsavel) references Colaboradores(id);

insert into colaboradores (nome, cpf, cargo) values ("Rafael", "123", "Desenvolvedor"), ("Murilo", "234", "Desenvolvedor"), ("William", "456", "Gerente");
insert into colaboradores (nome, cpf, cargo) values ("Fabiola", "197", "Desenvolvedor"), ("Thiago", "958", "Gerente"), ("Marcelo", "1589", "Gerente");
insert into projetos (nome, descricao, responsavel) values ("Projeto 1", "xxxxxxx", 3),("Projeto 2", "yyyy", 3);
insert into tarefas (nome, descricao, prazo, projeto, responsavel) values ("Tarefa 1","tttt",15,1,1), ("Tarefa 2","rrrrr",10,1,2),("Tarefa 1","rsrsrs",5,2,2), ("Tarefa 2","rrrrr",45,2,1);

select * from tarefas;
select * from projetos;
select * from colaboradores;

/*geração de relatórios*/
/*1 - Listar todos os Gerentes ordenados pelo nome.*/

select nome, cargo, cpf from colaboradores where cargo = "Gerente";
select nome, cargo from colaboradores where cargo = "Gerente" order by nome asc;
select nome, cargo from colaboradores where cargo = "Gerente" order by nome desc;

/*2 - Listar todos os Projetos que estão em andamento.*/

alter table projetos add status tinyint;
alter table projetos add dataInicio date;
alter table projetos add dataTermino date;

/*status = 0 - projeto não iniciado, status = 1 - projeto em andamento e 
status =2 - projeto conclúido*/

update projetos set status = 1 where id = 1;
update projetos set status = 1, dataInicio = "2023-01-25" where id = 1;
update projetos set status = 2, dataInicio = "2023-01-29", 
dataTermino = "2023-03-14" where id = 2;

select * from projetos where status = 1;

select projetos.nome, projetos.descricao, projetos.dataInicio, 
colaboradores.nome from projetos, colaboradores 
where projetos.status = 1 and 
projetos.responsavel = colaboradores.id;

select p.nome, p.descricao, p.dataInicio, c.nome from 
projetos as p, colaboradores as c 
where p.status = 1 and p.responsavel = c.id;

select p.nome as "Projeto", p.descricao as "Descrição", 
p.dataInicio as "Data de inicio", c.nome as "Gerente" from 
projetos as p, colaboradores as c 
where p.status = 1 and p.responsavel = c.id;

select * from projetos where status = 1 and dataInicio > "0000-00-00";

/*3 - Listar todos os Projetos que estão concluídos.*/
insert into projetos (nome, descricao, responsavel, status) values ("Projeto 12", "xxxxxxx", 4, 2),("Projeto 22", "yyyy", 5, 2);
select * from projetos where status = 2;

select p.nome as "Projeto", p.descricao as "Descrição", 
p.dataInicio as "Data de inicio", c.nome as "Gerente" from 
projetos as p, colaboradores as c 
where p.status = 2 and p.responsavel = c.id;

/*4 - Listar as tarefas de cada desenvolvedor.*/

SELECT t.nome, c.nome  FROM tarefas as t, colaboradores as c where t.responsavel = c.id order by t.responsavel asc;
/*select * from tarefas where respo = "Desenvolvedor"*/

/*5 - Listar as tarefas de cada projeto.*/
SELECT p.nome as 'Projeto', p.responsavel as 'Gerente', t.nome as 'Tarefa', c.nome as 'Responsável' 
FROM projetos as p, tarefas as t, colaboradores as c
 where 
 t.projeto = p.id and t.responsavel = c.id 
 order by p.nome asc;
 
 SELECT p.nome as 'Projeto', p.responsavel as 'Gerente', t.nome as 'Tarefa', c.nome as 'Responsável' 
 FROM projetos as p, tarefas as t, colaboradores as c
 where 
 t.projeto = p.id and p.responsavel = c.id and t.responsavel = c.id
 order by p.nome asc;

ALTER TABLE colaboradores ADD arquivo VARCHAR(255);
