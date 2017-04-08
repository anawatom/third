import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

// Custom components
import { SideMenuContentComponent } from '../components/side-menu/side-menu';

// Pages
import { MainPage } from '../pages/main-page/main-page';
import { Page2 } from '../pages/page2/page2';

@NgModule({
  declarations: [
    MyApp,
    SideMenuContentComponent,
    MainPage,
    Page2
  ],
  imports: [
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    MainPage,
    Page2
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}]
})
export class AppModule {}
