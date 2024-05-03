#include "statistique.h"
#include "ui_statistique.h"

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


#include <QtCharts>
statistique::statistique(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::statistique)
{
    ui->setupUi(this);
}

statistique::~statistique()
{
    delete ui;
}

void statistique::on_pushButton_clicked()
{
    QChartView *chartView;
    QSqlQuery q1, q2 ,q3 , q4, q5;
    qreal tot = 0, c1 = 0 , c2 = 0, c3 = 0, c4 = 0;

    q1.prepare("SELECT count(*) FROM FOOL");
    q1.exec();
    q1.next();
    tot = q1.value(0).toDouble();
    q2.prepare("SELECT count(*) FROM FOOL WHERE SECTEUR_ACTIVITE='commerce'");
    q2.exec();
    q2.next();
    c1 = q2.value(0).toDouble();

    q3.prepare("SELECT count(*) FROM FOOL WHERE SECTEUR_ACTIVITE='it'");
    q3.exec();
    q3.next();
    c2 = q3.value(0).toDouble();

    q4.prepare("SELECT count(*) FROM FOOL WHERE  SECTEUR_ACTIVITE='telecommunication'");
    q4.exec();
    q4.next();
    c3 = q4.value(0).toDouble();

    q5.prepare("SELECT count(*) FROM FOOL WHERE  SECTEUR_ACTIVITE='education'");
    q5.exec();
    q5.next();
    c4 = q5.value(0).toDouble();
    // Calculer les proportions pour chaque tranche
    c1 /= tot;
    c2 /= tot;
    c3 /= tot;
    c4 /= tot;

    qreal c1Percent = c1 * 100;
    qreal c2Percent = c2 * 100;
    qreal c3Percent = c3 * 100;
    qreal c4Percent = c4 * 100;

    QPieSeries *series = new QPieSeries();
    QPieSlice *slice1 = series->append("Commerce", c1);
    QPieSlice *slice2 = series->append("IT", c2);
    QPieSlice *slice3 = series->append("Télécommunications", c3);
    QPieSlice *slice4 = series->append("Education", c4);

    slice1->setBrush(QColor("#CE6A6B")); // Red color
    slice2->setBrush(QColor("#212E53")); // Blue color
    slice3->setBrush(QColor("#4A919E"));
    slice4->setBrush(QColor("#BED3C3"));


    slice1->setLabel(slice1->label() + " (" + QString::number(c1Percent, 'f', 2) + "%)");
    slice2->setLabel(slice2->label() + " (" + QString::number(c2Percent, 'f', 2) + "%)");
    slice3->setLabel(slice3->label() + " (" + QString::number(c3Percent, 'f', 2) + "%)");
    slice4->setLabel(slice4->label() + " (" + QString::number(c4Percent, 'f', 2) + "%)");







    QChart *chart = new QChart();
    chart->addSeries(series);
    chart->legend()->show();
    chart->setAnimationOptions(QChart::AllAnimations);
    chart->setTheme(QChart::ChartThemeLight);//disable the theme
    chart->setTitle("Répartition des secteurs d'activité selon leur nombre ");
    chart->setTitleFont(QFont("Segoe Print"));
    chartView = new QChartView(chart, ui->Employe_label_Stats);
    chartView->setRenderHint(QPainter::Antialiasing);
    chartView->setMinimumSize(570, 570);
    chartView->show();

    QBarSet *commerceSet = new QBarSet("Commerce");
    *commerceSet << c1;
    commerceSet->setColor(QColor("#CE6A6B"));


    QBarSet *itSet = new QBarSet("IT");
    *itSet << c2;
    itSet->setColor(QColor("#212E53")); // Utiliser la même couleur que le diagramme circulaire

    QBarSet *telecomSet = new QBarSet("Télécommunications");
    *telecomSet << c3;
    telecomSet->setColor(QColor("#4A919E")); // Utiliser la même couleur que le diagramme circulaire

    QBarSet *educationSet = new QBarSet("Education");
    *educationSet << c4;
    educationSet->setColor(QColor("#BED3C3"));



    QBarSeries *seriesBaton = new QBarSeries();
    seriesBaton->append(commerceSet);
    seriesBaton->append(itSet);
    seriesBaton->append(telecomSet);
    seriesBaton->append(educationSet);





    QChart *chartBaton = new QChart();
    chartBaton->addSeries(seriesBaton);

    chartBaton->setTitle("Répartition des secteurs d'activité selon leur nombre");
    chartBaton->setTitleFont(QFont("Segoe Print"));





    chartBaton->setAnimationOptions(QChart::AllAnimations);
    chartBaton->setTheme(QChart::ChartThemeLight);








    QBarCategoryAxis *axisXBaton = new QBarCategoryAxis();
    axisXBaton->append("Commerce");
    axisXBaton->append("IT");
    axisXBaton->append("Télécommunications");
    axisXBaton->append("Education");
    chartBaton->addAxis(axisXBaton, Qt::AlignBottom);

    QValueAxis *axisYBaton = new QValueAxis();
    chartBaton->addAxis(axisXBaton, Qt::AlignBottom);

    QChartView *chartViewBaton = new QChartView(chartBaton, ui->thanya_label_Stats);
    chartViewBaton->setRenderHint(QPainter::Antialiasing);

    chartViewBaton->setMinimumSize(570, 570);
    chartViewBaton->show();




}


