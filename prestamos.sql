drop database if exists prestamos;
create database prestamos;
use prestamos;

create table usuario(
  id int not null auto_increment primary key,
  nombre varchar(255) not null,
  apellido varchar(255) not null,
  nickname varchar(100) not null,
  contrasena varchar(50) not null,
  is_admin boolean not null
);

create table alumno(
  matricula varchar(9) primary key,
  nombre varchar(100) not null,
  apellidoPaterno varchar(100) not null,
  apellidoMaterno varchar(100) not null,
  carrera varchar(50) not null
);

create table profesor(
  noPersonal varchar(5) primary key,
  nombre varchar(100) not null
);

create table aula (
  id int not null auto_increment primary key,
  nombre varchar(255) not null
);

create table materia (
  nrc varchar(5) not null primary key,
  nombre varchar(255) not null
);

create table tipo_dispositivo(
  id int not null auto_increment primary key,
  nombre varchar(255) not null
);

# time=hh:mm date=YYYY-MM-DD
create table prestamo(
  id int not null auto_increment primary key,
  fecha date not null,
  horario_entrada time not null,
  horario_salida time not null,
  is_active boolean null,
  nrc_materia varchar(5) not null,
  id_aula int not null,
  id_usuario int not null,
  id_profesor varchar(5),
  id_alumno varchar(9),
  foreign key (id_usuario) references usuario(id),
  foreign key (id_profesor) references profesor(noPersonal),
  foreign key (id_alumno) references alumno(matricula),
  foreign key (nrc_materia) references materia(nrc),
  foreign key (id_aula) references aula(id)
);

create table dispositivo(
  id varchar(50) not null primary key,
  nombre varchar(255) not null,
  cantidad int not null,
  prestado int not null,
  observaciones varchar(255)
);

create table dispositivo_prestado(
  id_prestamo int not null,
  id_dispositivo varchar(50) not null,
  prestado int not null,
  foreign key (id_prestamo) references prestamo(id),
  foreign key (id_dispositivo) references dispositivo(id)
);

# Usuario
insert into usuario (nombre, apellido, nickname, contrasena, is_admin) values (
  "luan",
  "avila",
  "luvi",
  "1234",
  true
);

insert into usuario (nombre, apellido, nickname, contrasena, is_admin) values (
  "marin",
  "aristeo",
  "goodboy",
  "1234",
  false
);

# Alumno
insert into alumno values (
  "s18014519",
  "CRISTIAN YAIR",
  "PENA",
  "CABRERA",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s19016407",
  "ROBERTO",
  "GONZALEZ",
  "PARTIDA",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s20022111",
  "OMAR ALFREDO",
  "HIDALGO",
  "JACINTO",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s19016388",
  "ANA PAULA",
  "ALVAN",
  "ARGUELLES",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s19023888",
  "AMAYRANI PAOLA",
  "MARTINEZ",
  "VILLA",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s19030171",
  "RICARDO",
  "MARTINEZ",
  "OLIVO",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s20018152",
  "MAILENE GABRIELA",
  "ALPUCHE",
  "VELAZQUEZ",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s20018150",
  "MATTAI",
  "MARTINEZ",
  "MONTERO",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s18019963",
  "EDGAR ANTONIO",
  "JIMENEZ",
  "LOPEZ",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s19016410",
  "JOYCE ENID",
  "GARCIA",
  "LOPEZ",
  "Tecnologias Computacionales"
);

insert into alumno values (
  "s18014489",
  "CESAR ALEJANDRO",
  "VALLEJO",
  "GALVAN",
  "Tecnologias Computacionales"
);

#profesor
insert into profesor values ("12310", "ALONSO RAMIREZ LORENA");
insert into profesor values ("12311", "ALONSO RAMIREZ OSCAR");
insert into profesor values ("12312", "CASTAÑEDA SANCHEZ FREDY");
insert into profesor values ("12313", "CORDOBA TLAXCALTECO MARIA LUISA");
insert into profesor values ("12314", "DELGADO RAMIREZ ATANASIO HERMILO");
insert into profesor values ("12315", "DIAZ GASPAR PATRICIA");
insert into profesor values ("12316", "GARCIA MENIER EVERARDO FRANCISCO");
insert into profesor values ("12317", "GARCIA VEGA VIRGINIA ANGELICA");
insert into profesor values ("12318", "GOMEZ ROMERO RAMON");
insert into profesor values ("12319", "GONZALEZ GASPAR PATRICIA");
insert into profesor values ("12320", "GUTIERREZ MENDEZ JUAN MANUEL");
insert into profesor values ("12321", "HERNANDEZ CALDERON JOSE GUILLERMO");
insert into profesor values ("12322", "HERNANDEZ OLIVERA VICTOR MANUEL");
insert into profesor values ("12323", "HERNANDEZ RODRIGUEZ MARIA DE LOURDES");
insert into profesor values ("12324", "MARINERO AGUILAR ULISES");
insert into profesor values ("12325", "MARTINEZ GUEVARA NIELS");
insert into profesor values ("12326", "MENESES RICO ERIKA");
insert into profesor values ("12327", "MILLAN MARTINEZ MAX WILLIAM");
insert into profesor values ("12328", "MONTANE JIMENEZ LUIS GERARDO");
insert into profesor values ("12329", "NAVARRO GUERRERO MARIA DE LOS ANGELES");
insert into profesor values ("12330", "OCHOA MARTINEZ OCTAVIO ENRIQUE");
insert into profesor values ("12331", "ORDUÑA GONZALEZ AQUILES");
insert into profesor values ("12332", "ORTEGA GIJON YOSELYN NOHEMI");
insert into profesor values ("12333", "REYES ESTUDILLO YANETH");
insert into profesor values ("12334", "REYES FLORES ITZEL ALESSANDRA");
insert into profesor values ("12335", "RODRIGUEZ RAMIREZ RUTH");
insert into profesor values ("12336", "ROJAS LUNA ALICIA YAZMIN");
insert into profesor values ("12337", "SANCHEZ OREA ALFONSO");
insert into profesor values ("12338", "SARMIENTO CERVANTES RAMON DAVID");
insert into profesor values ("12339", "SOTO ORTIZ JOSE LUIS");
insert into profesor values ("12340", "VALDERRABANO PEDRAZA DIANA ELIZABETH");

# Dispositivos
insert into dispositivo values ("F101", "control F101", 1, 0, "Un boton no sirve");
insert into dispositivo values ("F102", "control F102", 1, 0, "");
insert into dispositivo values ("F103", "control F103", 1, 0, "Restos de chocolate");
insert into dispositivo values ("F104", "control F104", 1, 0, "");
insert into dispositivo values ("F105", "control F105", 1, 0, "Roto, tiene cinta adhesiva");
insert into dispositivo values ("1212", "HDMI", 5, 0, "");
insert into dispositivo values ("1213", "Adaptador Mac", 3, 0, "");
insert into dispositivo values ("1214", "Adaptador GBA", 4, 0, "Pines rotos");
insert into dispositivo values ("1215", "Laptop", 2, 0, "Sin procesadores");

# Aulas
insert into aula (nombre) values ("102");
insert into aula (nombre) values ("103");
insert into aula (nombre) values ("104");
insert into aula (nombre) values ("105");
insert into aula (nombre) values ("106");
insert into aula (nombre) values ("111");
insert into aula (nombre) values ("112");
insert into aula (nombre) values ("113");
insert into aula (nombre) values ("F101");
insert into aula (nombre) values ("F102");
insert into aula (nombre) values ("F103");
insert into aula (nombre) values ("F104");
insert into aula (nombre) values ("F105");
insert into aula (nombre) values ("F402");
insert into aula (nombre) values ("F403");
insert into aula (nombre) values ("FTC");
insert into aula (nombre) values ("CC1");
insert into aula (nombre) values ("CC2");
insert into aula (nombre) values ("CC3");
insert into aula (nombre) values ("CC4");

# materia
insert into materia values ("12346", "Administración de servidores");
insert into materia values ("12347", "Algebra lineal para computación");
insert into materia values ("12348", "Bases de datos");
insert into materia values ("12349", "Bases de datos avanzadas");
insert into materia values ("12350", "Computación básica");
insert into materia values ("12351", "Desarrollo de software");
insert into materia values ("12352", "Desarrollo movil");
insert into materia values ("12353", "Estructura de datos");
insert into materia values ("12354", "Ética y legislación informática");
insert into materia values ("12355", "Fundamentos de matemáticas");
insert into materia values ("12356", "Gestión de proyectos de tecnologías de información");
insert into materia values ("12357", "Habilidades del pensamiento crítico y creativo");
insert into materia values ("12358", "Habilidades directivas");
insert into materia values ("12359", "Ingeniería de software");
insert into materia values ("12360", "Inglés I");
insert into materia values ("12361", "Inglés II");
insert into materia values ("12362", "Integración de soluciones");
insert into materia values ("12363", "Interación humano computadora");
insert into materia values ("12364", "Introducción a la programación");
insert into materia values ("12365", "Matemáticas discretas");
insert into materia values ("12366", "Metodología de la Investigacion");
insert into materia values ("12367", "Metodologias de desarollo");
insert into materia values ("12368", "Organización de compuadoras");
insert into materia values ("12369", "Probabilidad y estadística para computación");
insert into materia values ("12370", "Programación");
insert into materia values ("12371", "Programación avanzada");
insert into materia values ("12372", "Proyecto integrador");
insert into materia values ("12373", "Redes");
insert into materia values ("12374", "Seguridad");
insert into materia values ("12375", "Sistemas inteligentes");
insert into materia values ("12376", "Sistemas operativos");
insert into materia values ("12377", "Sistemas web");
insert into materia values ("12378", "Tecnologías de información para la innovación");
insert into materia values ("12379", "Tecnologías para la integración de soluciones");
insert into materia values ("12380", "Tecnologías web");

# Tipo dispositivo
insert into tipo_dispositivo (nombre) values ("Control");
insert into tipo_dispositivo (nombre) values ("HDMI");
insert into tipo_dispositivo (nombre) values ("Laptop");
insert into tipo_dispositivo (nombre) values ("Cámara");
insert into tipo_dispositivo (nombre) values ("Adaptador");
insert into tipo_dispositivo (nombre) values ("Proyector");

#######################################################################

# Obtener id, nombre, observaciones de los dispositivos en un prestamo con el id del prestamo
select d.id, d.nombre, d.observaciones
from dispositivo_prestado as dp
inner join dispositivo as d on dp.id_dispositivo=d.id
where dp.id_prestamo=1;
