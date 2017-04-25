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
export class DetailData {
  constructor(private http: Http) {}

  fetchData(type: string, id: number): Observable<DetailData[]> {
    let urlData = this.formatURL(type, id);
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
      return this.formatData(type, res.json().data);
    });
  }

  private formatURL(type: string, id: number) {
    let result: any = {};

    if (type === 'article') {
      result = {
        'url': BASE_API_URL + 'ws/service/get-tbl-article',
        'params': [
          'ArticleCategorySubId=' + id
        ]
      };
    } else if (type === 'gallery') {
      result = {
        'url': BASE_API_URL + 'ws/service/get-tbl-gallery-photo',
        'params': [
          'GalleryMainGalleryId=' + id
        ]
      };
    }

    return result;
  }

  private formatData(type: string, data: any): any[] {
    let result = [];

    if (type === 'article') {
      _.each(data, (e,i) => {
        result.push({
          id: e.ArticleId,
          type: type,
          title: e.ArticleTitleTH,
          imagePath: 'http://www.dpe.go.th/home/thumb/article/' + e.ArticlePic + '/207/288',
          filePath: 'http://www.dpe.go.th/content/file/article/' + e.ArticleFileTH
        });
      });
    } else if (type === 'gallery') {
      _.each(data, (e,i) => {
        result.push({
          id: e.GalleryMainGalleryId,
          type: type,
          imagePath: 'http://www.dpe.go.th/home/thumbmain/' +  e.GalleryMainGalleryId + '/' + e.GalleryMainPic + '/180/110/'
        });
      });
    }

    return result;
  }
}
