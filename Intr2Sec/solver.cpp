#include <iostream>
#include <string>
#include <sstream>
#include <fstream>
#include <vector>
#include <bitset>

using namespace std;



void str2IntVec(vector<int>& vec,const  string& str){
	for (int i=0; i<str.length();){
		char t1 = str[i++];
		char t2 = str[i++];
		int a;		
		stringstream ss;
		ss<<hex<<t1<<t2;
		ss>>a;
		vec.push_back(a);
	}	
	
}

vector<int> doTheMagic(const vector<int>& vec1, const vector<int>& vec2){
	vector<int>::const_iterator it1 = vec1.begin();
	vector<int>::const_iterator it2 = vec2.begin();

	vector<int> ret;
	while (it1!=vec1.end() && it2!=vec2.end()){
		ret.push_back( (*it1)^(*it2) );
		it1++;
		it2++;
	}
	return ret;
}


vector<int> xorStrings(const string& msg,const  string& inp){
	vector<int> msgInt;
	vector<int> inpInt;
	str2IntVec(msgInt, msg);
	str2IntVec(inpInt, inp);
	return doTheMagic(msgInt,inpInt);
}

void findSpaces(const vector<int>& vec){
	int space = 32;
	int calc=0;
	vector<int> pos;
	int i=0;
	for (vector<int>::const_iterator it = vec.begin(); it!=vec.end();it++){
		int result = (*it)^space;

		if (result==0){
			++calc;
			pos.push_back(i);
		}
		else if (( result>=65 && result<=90) || ( result>=97 && result<=122)) {
			//cout<<char(result);
			pos.push_back(i);
			++calc;
		}
		i++;
			
	}
	for (int j = 0; j<pos.size();j++){
		cout<<pos[j]<<" ";
	}	
	cout<<endl<<"total: "<<calc<<endl<<endl;
}

int main()
{
	ifstream msg1("msg.txt");
	string msg;
	msg1>>msg;
	msg1.close();

	vector<string> inputs;
	ifstream inp("input.txt");
	string tmpInp;
	while (inp>>tmpInp) {
		inputs.push_back(tmpInp);
	}
	inp.close();

	vector< vector<int> > xorStr;
	
	for (vector<string>::iterator iter = inputs.begin(); iter!=inputs.end();++iter){
		xorStr.push_back(xorStrings(msg,*iter));
	}
	
	for (int i=0;i<xorStr.size();++i){
		cout << "checkking: "<<i<<endl;
		findSpaces(xorStr[i]);
	}
	
	return 0;
}

