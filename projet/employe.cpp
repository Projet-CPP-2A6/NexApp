// employe.cpp

#include "employe.h"
#include <QSqlQuery>
#include <QSqlError>
#include <QSqlQueryModel>

Employe::Employe()
{

}

int Employe::getCIN() {
    return CIN;
}

QDate Employe::getDATE_EMB() {
    return DATE_EMB;
}

int Employe::getNUM_TEL() {
    return NUM_TEL;
}

QString Employe::getNOM() {
    return NOM;
}

QString Employe::getPRENOM() {
    return PRENOM;
}

QString Employe::getEMAIL_EMP() {
    return EMAIL_EMP;
}

QString Employe::getFONCTION() {
    return FONCTION;
}

int Employe::getSALAIRE() {
    return SALAIRE;
}

void Employe::setCIN(int nvCIN) {
    CIN = nvCIN;
}

void Employe::setDATE_EMB(QDate nvDATE_EMB) {
    DATE_EMB = nvDATE_EMB;
}

void Employe::setNOM(QString nvNOM) {
    NOM = nvNOM;
}

void Employe::setPRENOM(QString nvPRENOM) {
    PRENOM = nvPRENOM;
}

void Employe::setEMAIL_EMP(QString nvEMAIL_EMP) {
    EMAIL_EMP = nvEMAIL_EMP;
}

void Employe::setFONCTION(QString nvFONCTION) {
    FONCTION = nvFONCTION;
}

void Employe::setSALAIRE(int nvSALAIRE) {
    SALAIRE = nvSALAIRE;
}


QStandardItemModel* Employe::afficher() {
    int rows ;
    QStandardItemModel * model = new QStandardItemModel();
    model->setColumnCount(8);
    model->setHeaderData(0,Qt::Horizontal,"Nom");
    model->setHeaderData(1,Qt::Horizontal,"Prenom");
    model->setHeaderData(2,Qt::Horizontal,"Email");
    model->setHeaderData(3,Qt::Horizontal,"Salaire");
    model->setHeaderData(4,Qt::Horizontal,"Cin");
    model->setHeaderData(5,Qt::Horizontal,"Numero");
    model->setHeaderData(6,Qt::Horizontal,"Fonction");
    model->setHeaderData(7,Qt::Horizontal,"Date_Embauche");
    QSqlQuery query ;
    query.exec("SELECT* FROM EMPLOYE") ;
    // (query.next()) ==> next query
    while (query.next()) {
        rows = model->rowCount() ;
        model->insertRow(rows) ;
        for(int i = 0 ; i < 8 ; i++ ){
            model->setData(model->index(rows,i),query.value(i).toString());
        }
    }
    return model ;
}

bool Employe::EffacerEmploye(int n) {
    QSqlQuery q;
    q.prepare("DELETE FROM EMPLOYE WHERE CINE = :CIN");
    q.bindValue(":CIN", n);
    if (!q.exec()) {
        qDebug() << "Failed to delete row with CIN" << n << ":" << q.lastError().text();
        return false;
    } else {
        qDebug() << "Row with CIN" << n << "successfully deleted";
        // QSqlDatabase::database().commit(); // You may not need this if using auto-commit
        return true;
    }
}





bool Employe::Modifier_element(int cinnv,QDate nvde,int nvnumero,QString nvnom, QString nvprenom , QString nvemail, QString nvfonction,int nvsalaire ){
    QSqlQuery q;
    q.prepare("UPDATE EMPLOYE SET NOM = :v1, PRENOM = :v2, EMAIL_EMP = :v3, SALAIRE = :v4, NUM_TEL = :v6, FONCTION = :v7, DATE_EMB = :v8  WHERE \"CINE\" = :v5");
    q.bindValue(":v1", nvnom);
    q.bindValue(":v2", nvprenom);
    q.bindValue(":v3", nvemail);
    q.bindValue(":v4", nvsalaire);
    q.bindValue(":v5", cinnv);
    q.bindValue(":v6", nvnumero);
    q.bindValue(":v7", nvfonction);
    q.bindValue(":v8", nvde);
    if (!q.exec()) {
        qDebug() << "Error executing SQL query:" << q.lastError().text();
        return false;
    }
    return true;
}

bool Employe::AjouterEmploye(int cinnv,QDate nvde,int nvnumero,QString nvnom, QString nvprenom , QString nvemail, QString nvfonction,int nvsalaire )
{

    QSqlQuery q ;

    q.prepare("INSERT INTO EMPLOYE(NOM,PRENOM,EMAIL_EMP,SALAIRE,CINE,NUM_TEL,FONCTION,DATE_EMB) VALUES(:v1,:v2,:v3,:v4,:v5,:v6,:v7,:v8) ") ;
    q.bindValue(":v1",nvnom) ;
    q.bindValue(":v2",nvprenom) ;
    q.bindValue(":v3",nvemail) ;
    q.bindValue(":v4",nvsalaire) ;
    q.bindValue(":v5",cinnv) ;
    q.bindValue(":v6",nvnumero) ;
    q.bindValue(":v7",nvfonction) ;
    q.bindValue(":v8",nvde) ;
    if (! q.exec()) {
        qDebug() << "8alet" ;
        return false;
    }
    else {
        return true ;
    }
}

QStandardItemModel* Employe::recherche_cin(QString str) {
    int rows;
    QSqlQuery query;
    QStandardItemModel *model = new QStandardItemModel();
    model->setColumnCount(8);
    model->setHeaderData(0,Qt::Horizontal,"Nom");
    model->setHeaderData(1,Qt::Horizontal,"Prenom");
    model->setHeaderData(2,Qt::Horizontal,"Email");
    model->setHeaderData(3,Qt::Horizontal,"Salaire");
    model->setHeaderData(4,Qt::Horizontal,"Cin");
    model->setHeaderData(5,Qt::Horizontal,"Numero");
    model->setHeaderData(6,Qt::Horizontal,"Fonction");
    model->setHeaderData(7,Qt::Horizontal,"Date_Embauche");
    int cinv = str.toInt();
    // Adjusted query to search by CIN
    query.prepare("SELECT * FROM EMPLOYE WHERE CINE = :x");
    query.bindValue(":x", cinv);

    if (query.exec()) {
        while (query.next()) {
            rows = model->rowCount();
            model->insertRow(rows);
            for (int i = 0; i < 6; i++) {
                model->setData(model->index(rows, i), query.value(i).toString());
            }
        }
    } else {
        qDebug() << "Query failed:" << query.lastError();
    }
    return model;
}

