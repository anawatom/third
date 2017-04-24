import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

// providers
import { ListData } from '../../providers/list-data/list-data';
import { LoaderHelper } from '../../providers/loader-helper/loader-helper';

// Pipes
import { SafeHtml } from '../../pipes/safe-html';

@Component({
  selector: 'list-page',
  templateUrl: 'list-page.html',
  providers: [ListData, LoaderHelper]
})
export class ListPage {
  public title: string = '';
  public data: Array<{id: number,
                        imagePath: string,
                        title: string,
                        description?: string
                        htmlDescription?: string}> = [];

  constructor(
    private navCtrl: NavController,
    private navParams: NavParams,
    private loaderHelper: LoaderHelper,
    private listData: ListData
  ) {
    this.title = this.navParams.get('title');

    this.loaderHelper.show();
    this.listData.fetchData(this.navParams.get('htmlContent'))
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
