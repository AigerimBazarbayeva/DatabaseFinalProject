#include <iostream>
#include <vector>
#include <set>
#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <ctime>

using namespace std;

char buffer[1024];
char boolean[2][10] = {"false", "true"};

// Lists with names of objects
vector <string> planetarySystems_list;
vector <string> planets_list;
vector <string> stars_list;
vector <string> moons_list;

// Resulting queries for objects
vector <string> planetarySystems_result;
vector <string> planets_result;
vector <string> stars_result;
vector <string> moons_result;

void move_strptr(char*& ptr) {
 	while (*ptr)
 		ptr++;
}

string generate_random_string(int length) {
 	string result;

 	int nlength = rand() % length + 1;

 	for (int i = 0; i < nlength; i++) {
 	 	result.append(1, rand() % 26 + 'a');
 	}

 	static set <string> result_set;
 	if (result_set.find(result) != result_set.end())
 		return generate_random_string(length);
 	
 	result_set.insert(result);
 	return result;
}

void generate_lists() {
 	srand(time(NULL));
 	
 	for (int i = 0; i < 5; i++) {
 	 	planetarySystems_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 20; i++) {
 	 	planets_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 20; i++) {
 	 	stars_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 10; i++) {                        	
 	 	moons_list.push_back(generate_random_string(10));
 	}
}

void strcopy(char*& dest, const char *source) {
 	strcpy(dest, source);
 	move_strptr(dest);
}

void generate_queries() {
 	freopen("temp.sql", "w", stdout);

 	for (size_t i = 0; i < stars_list.size(); i++) {
 		char* buffptr = buffer;

 		strcopy(buffptr, "INSERT INTO spaceObject(name, radius, mass, EarthDistance, age, rotationSpeed, galaxyName, galaxyType, ownerID) VALUES('");
 		strcopy(buffptr, stars_list[i].c_str());
 		strcopy(buffptr, "'");

 		for (int j = 0; j < 5; j++) {
 		 	sprintf(buffptr, ", %d", rand() % 100 + 1);
 		 	move_strptr(buffptr);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', 1);\n");

 		printf("%s", buffer);

		buffptr = buffer;
 		strcopy(buffptr, "INSERT INTO star(OName, starType, color) VALUES('");
 		strcopy(buffptr, stars_list[i].c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(10).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(10).c_str());
 		strcopy(buffptr, "');\n");
 		
 		stars_result.push_back(string(buffer));
 	}
	puts("");

	for (size_t i = 0; i < stars_result.size(); i++) {
		printf("%s", stars_result[i].c_str());
 	}
 	puts("");

 	for (int i = 0; i < 5; i++) {
 	 	char *buffptr = buffer;

 	 	strcopy(buffptr, "INSERT INTO planetarySystem(name, starName, description) VALUES('");
 	 	strcopy(buffptr, planetarySystems_list[i].c_str());
 	 	strcopy(buffptr, "', '");
 	 	strcopy(buffptr, stars_list[i].c_str());
 	 	strcopy(buffptr, "', '");
 	 	strcopy(buffptr, generate_random_string(100).c_str());
 	 	strcopy(buffptr, "');\n");
 	 	planetarySystems_result.push_back(string(buffer));

 	 	printf("%s", buffer);
 	}
 	puts("");

 	for (size_t i = 0; i < planets_list.size(); i++) {
 		char* buffptr = buffer;

 		strcopy(buffptr, "INSERT INTO spaceObject(name, radius, mass, EarthDistance, age, rotationSpeed, galaxyName, galaxyType, ownerID) VALUES('");
 		strcopy(buffptr, planets_list[i].c_str());
 		strcopy(buffptr, "'");

 		for (int j = 0; j < 5; j++) {
 		 	sprintf(buffptr, ", %d", rand() % 100 + 1);
 		 	move_strptr(buffptr);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', 1);\n");

 		printf("%s", buffer);

		buffptr = buffer;
 		strcopy(buffptr, "INSERT INTO planet(OName, isLiveable, hasWater, hasAtmosphere, planetarySystemName) VALUES('");
 		strcopy(buffptr, planets_list[i].c_str());
 		strcopy(buffptr, "'");
 		
 		for (int j = 0; j < 3; j++) {
 			strcopy(buffptr, ", ");
 			strcopy(buffptr, boolean[rand() & 1]);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, planetarySystems_list[rand() % planetarySystems_list.size()].c_str());
 		strcopy(buffptr, "');\n");
 		
 		planets_result.push_back(string(buffer));
 	}
 	puts("");

	for (size_t i = 0; i < planets_result.size(); i++) {
		printf("%s", planets_result[i].c_str());
 	}
}

int main() {
	generate_lists();

	generate_queries();
	return 0;
}
