<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            $this->pageTitle = 'Location Viewer';
            $this->layout = '//layouts/column1';
            $this->render('index');
	}
}