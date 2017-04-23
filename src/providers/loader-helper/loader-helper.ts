import { Injectable } from '@angular/core';
import { LoadingController, Loading } from 'ionic-angular';

@Injectable()
export class LoaderHelper {
  private loader: Loading;
  constructor(
    private loadingCtrl: LoadingController
  ) {
    this.loader = this.loadingCtrl.create({
      content: "กรุณารอสักครู่..."
    });
  }

  show() {
    this.loader.present();
  }

  hide() {
    this.loader.dismiss();
  }
}
