<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 23.09.14
     * Time: 15:22
     */

    namespace app\controllers;

    use app\models\Manufacturer;
    use app\models\SalesUser;
    use app\models\User;
    use Yii;
    use yii\web\ForbiddenHttpException;

    class ManufacturerController extends PpdBaseController
    {
        public $modelName = 'app\models\Manufacturer';

        public function actionCreate()
        {
            if (Yii::$app->user->can('createManufacturer')) {
                $user = Yii::$app->user->identity;
                /**@var Manufacturer $salesUser */
                $manufacturer = new Manufacturer();

                $passForNewUser = Yii::$app->security->generateRandomString(6);
                $relatedUser = new User(
                    [
                        'roleField'       => User::ROLE_MAN,
                        'password'        => $passForNewUser,
                        'password_repeat' => $passForNewUser,
                    ]);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $manufacturer->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->createModel()) {
                        $manufacturer->user_id = $relatedUser->id;
                        if ($manufacturer->createModel()) {
                            return $this->redirect(['view', 'id' => $manufacturer->id]);
                        }
                    } else {
                        return $this->render('create-' . $user->role,
                            [
                                'manufacturer' => $manufacturer,
                                'relatedUser'  => $relatedUser,
                            ]);
                    }
                } else {
                    return $this->render('create-' . $user->role, [
                        'manufacturer' => $manufacturer,
                        'relatedUser'  => $relatedUser,
                    ]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        public function actionUpdate($id)
        {

            if (Yii::$app->user->can('updateManufacturer', ['modelId' => $id])) {

                $user = Yii::$app->user->identity;
                /**@var Manufacturer $manufacturer */
                $manufacturer = $this->findModel($id);
                /**@var User $relatedUser */
                $relatedUser = $manufacturer->user;

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $manufacturer->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->updateModel() && $manufacturer->updateModel()) {
                        return $this->redirect(['view', 'id' => $manufacturer->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['manufacturer' => $manufacturer, 'relatedUser' => $relatedUser]);
                    }
                } else {
                    return $this->render('update-' . $user->role, ['manufacturer' => $manufacturer, 'relatedUser' => $relatedUser]);
                }

            } else {
                throw new ForbiddenHttpException;
            }
        }
    }