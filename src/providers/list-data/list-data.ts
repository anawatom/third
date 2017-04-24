import { Injectable } from '@angular/core';
import { Http, URLSearchParams, Response } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';
import _ from 'lodash';

import { BASE_API_URL } from '../constant.ts';


/*
  Generated class for the Testing provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class ListData {
  constructor(private http: Http) {}

  fetchData(url: string): Observable<ListData[]> {
    let urlData = this.formatURL(url);
    let params = new URLSearchParams();
    if (urlData.params) {
      _.each(urlData.params, (e, i) => {
        let splitValue = e.split('='); // Format name=value
        params.set(splitValue[0], splitValue[1]);
      });
    }

    // @TODO: Handle when URL is not correct
    return this.http.get(urlData.url, {
      'search': params
    })
    .map((res: Response) => {
      return this.formatData(urlData.type, res.json().data);
    });
  }

  /*
  * @params
  *   url => /th/manager/11
  */
  private formatURL(url: string) {
    let result: any = {};
    let splitURL = url.split('/');
    let id: number = 0;
    if ( !isNaN(parseInt(splitURL[splitURL.length - 1])) ) {
      id = parseInt(splitURL[splitURL.length - 1]);
    }

    if (url.indexOf('manager') !== -1) {
      result = {
        'type': 'manager',
        'url': BASE_API_URL + 'ws/service/get-tbl-manager&Manager',
        'params': [
          'ManagerDepartmentId=' + id
        ]
      };
    } else if (url.indexOf('publishing') !== -1) {
      result = {
        'type': 'download',
        'url': BASE_API_URL + 'ws/service/get-tbl-download',
        'params': [
          'DownloadCategoryId=' + id
        ]
      };
    }

    return result;
  }

  private formatData(type: string, data: any): any[] {
    let result = [];

    if (type === 'manager') {
      _.each(data, (e,i) => {
        result.push({
          id: e.ManagerDepartmentId,
          type: type,
          imagePath: 'http://www.dpe.go.th/content/images/manager/' + e.ManagerPic,
          title: e.ManagerNameTH,
          htmlDescription: '<p>ตำแหน่ง ' +e.ManagerPositionTH+ '</p>'
          + '<p>โทรศัพท์ ' + e.ManagerTel + '</p>'
          + '<p>โทรศัพท์ภายใน ' + e.ManagerExtension + '</p>'
          + '<p>อีเมล์ ' + e.ManagerEmail + '</p>'
        });
      });
    } else if (type === 'download') {
      _.each(data, (e,i) => {
        result.push({
          id: e.DownloadSortId,
          type: type,
          filePath: 'http://www.dpe.go.th/content/file/download/' + e.DownloadFile,
          title: e.DownloadNameTH,
          downloadCount: e.DownloadView
        });
      });
    }

    return result;
  }
}
