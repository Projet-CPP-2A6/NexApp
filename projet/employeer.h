#ifndef EMPLOYEER_H
#define EMPLOYEER_H

#include <QDialog>

namespace Ui {
class employeer;
}

class employeer : public QDialog
{
    Q_OBJECT

public:
    explicit employeer(QWidget *parent = nullptr);
    ~employeer();

private:
    Ui::employeer *ui;
};

#endif // EMPLOYEER_H
