import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

// Custom components
import { SideMenuContentComponent } from '../components/side-menu/side-menu';

// Pipes
import { SafeHtmlPipe } from '../pipes/safe-html-pipe';

// Pages
import { MainPage } from '../pages/main-page/main-page';
import { HtmlPage } from '../pages/html-page/html-page';
import { ListPage } from '../pages/list-page/list-page';
import { DetailPage } from '../pages/detail-page/detail-page';

@NgModule({
  declarations: [
    MyApp,
    SideMenuContentComponent,
    SafeHtmlPipe,
    MainPage,
    HtmlPage,
    ListPage,
    DetailPage
  ],
  imports: [
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    MainPage,
    HtmlPage,
    ListPage,
    DetailPage
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}]
})
export class AppModule {}
