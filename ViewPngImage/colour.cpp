#include <math.h>
#include <array>

#include "picosystem.hpp"

using namespace picosystem;

extern char image_png[];

void init() {
}

void update(uint32_t tick) {
}

void draw(uint32_t tick) {
  pen(0, 0, 0);
  clear();

  char r,g,b;
  int p = 0;
  for(int y=0; y<120; y++) {
    for(int x=0; x<120; x++) {
      r = image_png[p];
      p++;
      g = image_png[p];
      p++;
      b = image_png[p];
      p++;
      pen(r, g, b);
      pixel(x, y);
    }
  }
}