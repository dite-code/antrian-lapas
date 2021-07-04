package com.dite.lalupa;

	import android.app.*;
	import android.content.*;
	import android.webkit.*;
	import android.widget.*;

	public class JavascriptToJava extends Activity
	{
		Context mContext;

		/** Instantiate the interface and set the context */
		JavascriptToJava(Context c) {
			mContext = c;
		}

		/** Show a toast from the web page */
		@JavascriptInterface
		public void alert(String toast) {
			Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
		}

		@JavascriptInterface
		public void tes(String a){
			Toast.makeText(mContext, a, Toast.LENGTH_SHORT).show();
			//WebView webView = (WebView) findViewById(R.id.webview);
			//webView.loadUrl("http://nesia.online");
		}

	}
