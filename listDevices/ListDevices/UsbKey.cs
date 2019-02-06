using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ListDevices
{
    class UsbKey
    {
        private string name;
        private string uuid;
        private int freeSpaceInBytes;
        private int status_id;
        private int rack_number;
        private int port_number;
        private DateTime createtd_at;
        private DateTime updated_at;


        public string Name { get; }
        public string Uuid { get; }
        public int FreeSpaceInBytes { get; }
        public int Status_id { get; }
        public int Rack_number { get; }
        public int Port_number { get; }
        public DateTime Created_at { get; }
        public DateTime Updated_at { get; }


        public UsbKey(string name, string uuid, int freeSpaceInBytes, DateTime createtd_at, DateTime updated_at, int status_id = (int)Status.Disponible, int rack_number = 0, int port_number = 0)
        {
            this.name = name;
            this.uuid = uuid;
            this.freeSpaceInBytes = freeSpaceInBytes;
            this.status_id = status_id;
            this.rack_number = rack_number;
            this.port_number = port_number;
            this.createtd_at = createtd_at;
            this.updated_at = updated_at;
        }

    }
}
