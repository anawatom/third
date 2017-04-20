import { Component } from '@angular/core';

import { NavController } from 'ionic-angular';

@Component({
  selector: 'list-page',
  templateUrl: 'list-page.html'
})
export class ListPage {
  public title: string = '';
  constructor(public navCtrl: NavController) {

  }
}
