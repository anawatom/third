import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

// Pipes
import { SafeHtml } from '../../pipes/safe-html';
@Component({
  selector: 'detail-page',
  templateUrl: 'detail-page.html'
})
export class DetailPage {
  public title: string;
  public htmlContent: string;

  constructor(
    private navCtrl: NavController,
    private navParams: NavParams
  ) {
  }
}
