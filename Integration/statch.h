#ifndef STATCH_H
#define STATCH_H

#include <QDialog>

namespace Ui {
class statch;
}

class statch : public QDialog
{
    Q_OBJECT

public:
    explicit statch(QWidget *parent = nullptr);
    ~statch();

private slots:
    void on_pushButton_clicked();

private:
    Ui::statch *ui;
};

#endif // STATCH_H
