#ifndef SUPPRICH_H
#define SUPPRICH_H

#include <QDialog>

namespace Ui {
class supprich;
}

class supprich : public QDialog
{
    Q_OBJECT

public:
    explicit supprich(QWidget *parent = nullptr);
    ~supprich();

private slots:
    void on_pushButton_clicked();

private:
    Ui::supprich *ui;
};

#endif // SUPPRICH_H
