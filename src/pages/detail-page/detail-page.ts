import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

// Pipes
import { SafeHtml } from '../../pipes/safe-html';

// Providers
import { LoaderHelper } from '../../providers/loader-helper/loader-helper';
import { DetailData } from '../../providers/detail-data/detail-data';

@Component({
  selector: 'detail-page',
  templateUrl: 'detail-page.html',
  providers: [DetailData, LoaderHelper]
})
export class DetailPage {
  public id: number;
  public title: string;
  public type: string;
  public data: string;

  constructor(
    private navCtrl: NavController,
    private navParams: NavParams,
    private loaderHelper: LoaderHelper,
    private detailData: DetailData
  ) {
    this.id = this.navParams.get('id');
    this.title = this.navParams.get('title');
    this.type = this.navParams.get('type');

    this.loaderHelper.show();
    this.detailData.fetchData(this.type, this.id)
    .subscribe(
      (res: any) => {
        this.data = res;
        this.loaderHelper.hide();
        console.log(this.data);
        console.log('finally');
      },
      (error: any) => {
        console.log(error);
        this.loaderHelper.hide();
      }
    );
  }
}
