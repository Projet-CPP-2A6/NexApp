#include "statch.h"
#include "ui_statch.h"
#include <QtCharts>
#include <QSqlError>
#include <QDebug>
#include <QSqlQuery>
#include <QSqlError>
#include <QtDebug>
#include <QMessageBox>
#include <QtCharts/QBarSeries>
#include <QtCharts/QBarCategoryAxis>
#include <QtCharts/QValueAxis>
#include <QtSql/QSqlQuery>
#include "client.h"

statch::statch(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::statch)
{
    ui->setupUi(this);
}

statch::~statch()
{
    delete ui;
}

void statch::on_pushButton_clicked()
{

    QChartView *chartView;
    QSqlQuery query;
    qreal tot = 0, tunis = 0, djerba = 0, zahra = 0;

    // Compter le nombre total de clients
    query.exec("SELECT count(*) FROM CLIENTS");
    query.next();
    tot = query.value(0).toDouble();

    // Compter le nombre de clients pour Tunis
    query.exec("SELECT count(*) FROM CLIENTS WHERE ADRESSE='tunis'");
    query.next();
    tunis = query.value(0).toDouble();

    // Compter le nombre de clients pour Djerba
    query.exec("SELECT count(*) FROM CLIENTS WHERE ADRESSE='djerba'");
    query.next();
    djerba = query.value(0).toDouble();

    // Compter le nombre de clients pour Zahra
    query.exec("SELECT count(*) FROM CLIENTS WHERE ADRESSE='zahra'");
    query.next();
    zahra = query.value(0).toDouble();

    // Calculer les proportions pour chaque lieu
    tunis /= tot;
    djerba /= tot;
    zahra /= tot;

    // Créer un objet de série pour le diagramme circulaire
    QPieSeries *series = new QPieSeries();
    series->append("Tunis", tunis);
    series->append("Djerba", djerba);
    series->append("Zahra", zahra);

    // Créer le diagramme circulaire
    QChart *chart = new QChart();
    chart->addSeries(series);
    chart->legend()->show();
    chart->setAnimationOptions(QChart::AllAnimations);
    chart->setTheme(QChart::ChartThemeLight);
    chart->setTitle("Répartition des clients par lieu");

    // Afficher le diagramme dans un QChartView
    chartView = new QChartView(chart, ui->Employe_label_Stats);
    chartView->setRenderHint(QPainter::Antialiasing);
    chartView->setMinimumSize(570, 570);
    chartView->show();
}

