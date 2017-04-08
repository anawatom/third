import { Component } from '@angular/core';

import { NavController } from 'ionic-angular';

@Component({
  selector: 'main-page',
  templateUrl: 'main-page.html'
})
export class MainPage {

  constructor(public navCtrl: NavController) {
    console.log('Main page');
  }

}
