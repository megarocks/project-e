<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 23.09.14
     * Time: 15:22
     */

    namespace app\controllers;

    use app\models\SalesUser;
    use app\models\User;
    use Yii;
    use yii\web\ForbiddenHttpException;

    class SalesUserController extends PpdBaseController
    {
        public $modelName = 'app\models\SalesUser';

        public function actionCreate()
        {
            if (Yii::$app->user->can('createSalesUser')) {
                $user = Yii::$app->user->identity;
                /**@var SalesUser $salesUser */
                $salesUser = new SalesUser();

                $passForNewUser = Yii::$app->security->generateRandomString(6);
                $relatedUser = new User(
                    [
                        'roleField'       => User::ROLE_SALES,
                        'password'        => $passForNewUser,
                        'password_repeat' => $passForNewUser,
                    ]);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $salesUser->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->createModel()) {
                        $salesUser->user_id = $relatedUser->id;
                        if ($salesUser->createModel()) {
                            return $this->redirect(['view', 'id' => $salesUser->id]);
                        }
                    } else {
                        return $this->render('create-' . $user->role,
                            [
                                'salesUser'   => $salesUser,
                                'relatedUser' => $relatedUser,
                            ]);
                    }
                } else {
                    return $this->render('create-' . $user->role, [
                        'salesUser'   => $salesUser,
                        'relatedUser' => $relatedUser,
                    ]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        public function actionUpdate($id)
        {

            if (Yii::$app->user->can('updateSalesUser', ['modelId' => $id])) {

                $user = Yii::$app->user->identity;
                /**@var SalesUser $salesUser */
                $salesUser = $this->findModel($id);
                /**@var User $relatedUser */
                $relatedUser = $salesUser->user;

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $salesUser->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->updateModel() && $salesUser->updateModel()) {
                        return $this->redirect(['view', 'id' => $salesUser->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['salesUser' => $salesUser, 'relatedUser' => $relatedUser]);
                    }
                } else {
                    return $this->render('update-' . $user->role, ['salesUser' => $salesUser, 'relatedUser' => $relatedUser]);
                }

            } else {
                throw new ForbiddenHttpException;
            }
        }
    }