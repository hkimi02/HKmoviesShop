///////////////////////////////////////////////// /* Création des Tables */ ///////////////////////////////////////////
/*Table vol */
CREATE TABLE vol (
novol CHAR(6),
vildep VARCHAR2(30),
vilar VARCHAR2(30),
dep_h NUMBER(2),
dep_mn NUMBER(2),
ar_h NUMBER(2),
ar_mn NUMBER(2),
CONSTRAINT C1_vol PRIMARY KEY (novol)) ;
/*Table pilote */
CREATE TABLE pilote (
nopilote CHAR(4),
nom VARCHAR2(30),
Adresse VARCHAR2(30),
Salaire NUMBER(8,2),
prime NUMBER(8,2),
dateembauche DATE,
CONSTRAINT C1_pilo PRIMARY KEY(nopilote));
/*Table avion */
CREATE TABLE avion(
nuavion CHAR(4),
anneservice NUMBER(4),
nom VARCHAR2(50),
nbhvol NUMBER(8),
type CHAR(3),
CONSTRAINT C1_avion PRIMARY KEY (nuavion));
/*Table affectation */
CREATE TABLE affectation (
novol CHAR(6),
datevol DATE,
nopilote CHAR(4),
nuavion CHAR(4),
nbpass NUMBER(3),
CONSTRAINT C2_affect FOREIGN KEY(novol) REFERENCES vol (novol),
CONSTRAINT C3_affect FOREIGN KEY(nopilote) REFERENCES pilote(nopilote)) ;
/////////////////////////////////////////////////////* Insertion des enregistrements*/ /////////////////////////////////
/* Insertion - Table vol */
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF8810','PARIS','DJERBA',9,0,11,45);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF8809','DJERBA','PARIS',12,45,15,40);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('IW201','LYON','FORT DE FRANCE',9,45,15,25);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('IW655','LA HAVANE','PARIS',19,55,12,35);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('IW433','PARIS','ST-MARTIN',17,00,8,20);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('IW924','SYDNEY','COLOMBO',17,25,22,30);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('IT319','BORDEAUX','NICE',10,35,11,45);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF3218','MARSEILLE','FRANCFORT',16,45,19,10);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF3530','LYON','LONDRES',8,0,8,40);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF3538','LYON','LONDRES',18,35,19,15);
insert into Vol (novol,vildep,vilar,dep_h,dep_mn,ar_h,ar_mn)
values ('AF3570','MARSEILLE','LONDRES',9,35,10,20);
/* Insertion - Table pilote */
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('1333', 'FEDOI', 'NANTES', 24000.00, 0.00, '10/03/93');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('6589', 'DUVAL', 'PARIS', 18600.00, 5580.00, '12/03/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('7100', 'MARTIN', 'LYON', 15600.00, 16000.00, '07/01/93');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('3452', 'ANDRE', 'NICE', 22670.00, null, '12/12/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('3421', 'BERGER', 'REIMS', 18700.00, null, '08/12/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('6548', 'BARRE', 'LYON', 22680.00, 8600.00, '12/10/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('1243', 'COLLET', 'PARIS', 19000.00, 0.00, '12/04/93');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('5643', 'DELORME', 'PARIS', 21850.00, 9850.00, '07/01/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('6723', 'MARTIN', 'ORSAY', 23150.00, null, '07/05/93');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('8843', 'GAUCHER', 'CACHAN', 17600.00, null, '10/02/92');
insert into Pilote (nopilote,nom,adresse,salaire,prime,dateembauche)
values ('3465', 'PIC', 'TOURIS', 18650.00, null, '07/08/93');
/* Insertion - Table avion */
insert into avion (nuavion,nom,nbhvol,type)
values ('8832','Ville de Paris',16000,'734');
insert into avion (nuavion,nom,nbhvol,type)
values ('8567','Ville de Reims',8000,'734');
insert into avion (nuavion,nom,nbhvol,type)
values ('8467','Le Sud',600,'734');
insert into avion (nuavion,nom,nbhvol,type)
values ('7693','Pacifique',34000,'741');
insert into avion (nuavion,nom,nbhvol,type)
values ('8556',null,12000,'AB3');
insert into avion (nuavion,nom,nbhvol,type)
values ('8432','Malte',10600,'AB3');
insert into avion (nuavion,nom,nbhvol,type)
values ('8118',null,11800,'74E');
/* Insertion - Table affectation */
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW201','03/01/94',310,'6723','8567');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW201','03/02/94',265,'6723','8832');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF3218','06/12/94',83,'6723','7693');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF3530','11/12/94',178,'6723','8432');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF3530','12/03/94',156,'6723','8432');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF3538','12/01/94',110,'6723','8118');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW201','03/03/94',164,'1333','8567');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF8810','03/02/94',160,'7100','8556');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IT319','03/02/94',105,'3452','8432');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW433','03/12/94',178,'3421','8556');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW655','03/01/94',118,'6548','8118');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW655','03/02/94',402,'1243','8467');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW655',todate('dd-mm-yyyy','01/08/94'),198,'5643','8467');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW924',todate('dd-mm-yyyy','09/09/94'),412,'8843','8832');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('IW201',todate('dd-mm-yyyy','09/12/94'),156,'6548','8432');
insert into affectation (novol,datevol,nbpass,nopilote,nuavion)
values ('AF8810',todate('dd-mm-yyyy','09/12/94'),88,'6589','7693'); 