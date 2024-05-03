#include "stata.h"
#include "ui_stata.h"
#include "constat.h"
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


stata::stata(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::stata)
{
    ui->setupUi(this);
}

stata::~stata()
{
    delete ui;
}

void stata::on_pushButton_clicked()
{
    QChartView *chartView;
    QSqlQuery query;
    qreal tot = 0, tunis = 0, benarous = 0, gabes = 0;

    // Compter le nombre total de constats
    query.exec("SELECT count(*) FROM CONSTATS");
    query.next();
    tot = query.value(0).toDouble();

    // Compter le nombre de constats pour Tunis
    query.exec("SELECT count(*) FROM CONSTATS WHERE LIEU_CONSTAT='tunis'");
    query.next();
    tunis = query.value(0).toDouble();

    // Compter le nombre de constats pour Ben Arous
    query.exec("SELECT count(*) FROM CONSTATS WHERE LIEU_CONSTAT='benarous'");
    query.next();
    benarous = query.value(0).toDouble();

    // Compter le nombre de constats pour Gabès
    query.exec("SELECT count(*) FROM CONSTATS WHERE LIEU_CONSTAT='gabes'");
    query.next();
    gabes = query.value(0).toDouble();

    // Calculer les proportions pour chaque lieu
    tunis /= tot;
    benarous /= tot;
    gabes /= tot;

    // Créer un objet de série pour le diagramme circulaire
    QPieSeries *series = new QPieSeries();
    series->append("tunis", tunis);
    series->append("benarous", benarous);
    series->append("gabes", gabes);

    // Créer le diagramme circulaire
    QChart *chart = new QChart();
    chart->addSeries(series);
    chart->legend()->show();
    chart->setAnimationOptions(QChart::AllAnimations);
    chart->setTheme(QChart::ChartThemeLight);
    chart->setTitle("Répartition des constats par lieu");

    // Afficher le diagramme dans un QChartView
    chartView = new QChartView(chart, ui->Employe_label_Stats);
    chartView->setRenderHint(QPainter::Antialiasing);
    chartView->setMinimumSize(570, 570);
    chartView->show();
}

